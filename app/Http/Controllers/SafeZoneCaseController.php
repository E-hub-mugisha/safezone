<?php

namespace App\Http\Controllers;

use App\Mail\CaseSubmittedMail;
use App\Models\CaseNote;
use App\Models\SafeZoneCase;
use App\Models\User;
use App\Models\Evidence;
use App\Notifications\CaseStatusUpdated;
use App\Notifications\EmergencyAlert;
use App\Notifications\EvidenceAcceptedNotification;
use App\Services\TrackingLogService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SafeZoneCaseController extends Controller
{
    // List all cases
    public function index()
    {
        $cases = SafeZoneCase::with(['agent', 'medical', 'evidences'])->get();
        $agents = User::where('role', 'agent')->get();
        $medicalStaff = User::where('role', 'medical')->get();
        $users = User::all();

        return view('cases.index', compact('cases', 'agents', 'medicalStaff', 'users'));
    }

    // Show form for creating a new case
    public function create()
    {
        return view('safe_zone_cases.create');
    }

    // Store new case
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:physical,sexual,psychological',
            'description' => 'required|string',
            'location' => 'nullable|string',
            'evidences.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,mp4|max:20480',
        ]);

        $case = SafeZoneCase::create([
            'user_id' => auth()->id(),
            'type' => $request->type,
            'description' => $request->description,
            'location' => $request->location,
            'status' => 'pending',
        ]);

        if ($request->hasFile('evidences')) {
            foreach ($request->file('evidences') as $file) {
                $path = $file->store('evidences', 'public');
                Evidence::create([
                    'case_id' => $case->id,
                    'file_path' => $path,
                    'description' => $file->getClientOriginalName(),
                ]);
            }
        }

        TrackingLogService::log(
            $case->id,
            auth()->id(),
            'Case Created',
            "Case {$case->case_number} created by " . auth()->user()->name
        );

        // Notify all RIB agents
        $agents = User::where('role', 'agent')->get();
        foreach ($agents as $agent) {
            $agent->notify(new EmergencyAlert($case));
        }

        return redirect()->route('safe_zone_cases.index')->with('success', 'Case reported successfully.');
    }

    // Show single case
    public function show($id)
    {
        $case = SafeZoneCase::with(['agent', 'medical', 'evidences', 'trackingLogs', 'user'])->findOrFail($id);

        $agents = User::where('role', 'agent')->get();
        $medicalStaff = User::where('role', 'medical')->get();
        return view('cases.show', compact('case', 'agents', 'medicalStaff'));
    }

    // Update case (used for verification and assignment)
    public function update(Request $request, SafeZoneCase $safeZoneCase)
    {
        if ($request->has('verify')) {
            $safeZoneCase->update(['status' => 'verified']);
        } elseif ($request->has('assign')) {
            $request->validate([
                'agent_id' => 'required|exists:users,id',
                'medical_id' => 'required|exists:users,id',
            ]);
            $safeZoneCase->update([
                'agent_id' => $request->agent_id,
                'medical_id' => $request->medical_id,
                'status' => 'in_progress',
            ]);
        } elseif ($request->has('status')) {
            $safeZoneCase->update(['status' => $request->status]);
        }

        // Notify reporter
        $safeZoneCase->user->notify(new CaseStatusUpdated($safeZoneCase));

        return redirect()->back()->with('success', 'Case updated successfully.');
    }

    // Delete case
    public function destroy(SafeZoneCase $safeZoneCase)
    {
        // Delete related evidences files
        foreach ($safeZoneCase->evidences as $e) {
            if (Storage::disk('public')->exists($e->file_path)) {
                Storage::disk('public')->delete($e->file_path);
            }
        }

        $safeZoneCase->delete();
        return redirect()->back()->with('success', 'Case deleted successfully.');
    }

    // Show evidences for a case
    public function showEvidence($id)
    {
        $case = SafeZoneCase::with('evidences')->findOrFail($id);
        return view('cases.evidences', compact('case'));
    }

    // Store case
    public function storeCase(Request $request)
    {
        $request->validate([
            'type' => 'required|in:physical,sexual,psychological',
            'description' => 'required|string',
            'survivor_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'location' => 'nullable|string',
        ]);

        // Generate unique Case ID
        $latestCase = SafeZoneCase::latest()->first();
        $number = $latestCase ? $latestCase->id + 1 : 1;
        $caseID = 'SZC-' . date('Y') . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);

        // Create case
        $case = SafeZoneCase::create([
            'case_number' => $caseID,
            'survivor_name' => $request->survivor_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'type' => $request->type,
            'description' => $request->description,
            'location' => $request->location,
            'status' => 'pending',
        ]);

        // Save evidences if any
        if ($request->hasFile('evidences')) {
            foreach ($request->file('evidences') as $file) {
                $path = $file->store('evidences', 'public');
                Evidence::create([
                    'case_id' => $case->id,
                    'file_path' => $path
                ]);
            }
        }

        TrackingLogService::log(
            $case->id,
            auth()->id(),
            'Case Created',
            "Case {$case->case_number} created by " . auth()->user()->name
        );
        /**
         * SEND EMAIL NOTIFICATIONS
         */
        try {
            // 1. Send confirmation to the user
            Mail::to($case->email)->send(new CaseSubmittedMail($case));

            // 2. Notify all Admins
            $admins = User::where('role', 'admin')->pluck('email');
            foreach ($admins as $adminEmail) {
                Mail::to($adminEmail)->send(new CaseSubmittedMail($case, true));
            }

            // 3. Notify all RIB officers
            $ribUsers = User::where('role', 'rib')->pluck('email');
            foreach ($ribUsers as $ribEmail) {
                Mail::to($ribEmail)->send(new CaseSubmittedMail($case, true));
            }
        } catch (\Exception $e) {
            Log::error("Email sending failed: " . $e->getMessage());
        }


        return redirect()->back()->with('success', 'Case submitted successfully. Your Case ID: ' . $caseID);
    }

    public function trackCaseForm()
    {
        return view('cases-track');
    }

    public function trackCase(Request $request)
    {
        $request->validate([
            'case_number' => 'required|string'
        ]);

        $case = SafeZoneCase::with('evidences')->where('case_number', $request->case_number)->first();

        if (!$case) {
            return redirect()->back()->with('error', 'Case not found. Please check your Case ID.');
        }

        return view('cases-track', compact('case'));
    }

    public function addEvidence(Request $request, $id)
    {
        $case = SafeZoneCase::findOrFail($id);

        $request->validate([
            'type' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:255',
            'file' => 'required|file|mimes:jpg,png,pdf,docx,mp4|max:20480', // 20MB
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file'); // single file
            $path = $file->store('evidences', 'public');

            Evidence::create([
                'case_id' => $case->id,
                'type' => $request->type ?? 'other',
                'description' => $request->description ?? null,
                'file_path' => $path,
            ]);

            // ✅ Tracking log for this uploaded file
            TrackingLogService::log(
                $case->id,
                auth()->id(),
                'Evidence Added',
                "File: {$file->getClientOriginalName()}"
            );
        }

        // 🔔 Notify Admin & RIB roles
        $adminsAndRibs = User::whereIn('role', ['admin', 'rib'])->get();

        foreach ($adminsAndRibs as $user) {
            Mail::to($user->email)->send(new \App\Mail\NewEvidenceAddedMail($case));
        }

        return back()->with('success', 'Evidence uploaded successfully and admin/RIB notified.');
    }


    public function approveEvidence($id)
    {
        $evidence = Evidence::findOrFail($id);
        $evidence->status = 'accepted';
        $evidence->save();

        // Notify the case owner
        $case = $evidence->case;
        $user = User::where('email', $case->email)->first(); // assuming case submitter is also a registered user

        if ($user) {
            $user->notify(new EvidenceAcceptedNotification($evidence));
        }

        TrackingLogService::log(
            $case->id,
            auth()->id(),
            'Case Verified',
            "Verified by RIB Agent " . auth()->user()->name
        );

        return back()->with('success', 'Evidence approved and user notified.');
    }

    public function downloadPDF($id)
    {
        $case = SafezoneCase::with('evidences')->findOrFail($id);

        $pdf = PDF::loadView('case-report', compact('case'));
        $filename = $case->case_id . '_report.pdf';

        return $pdf->download($filename);
    }

    public function listReporter()
    {
        $reporters = SafeZoneCase::select('survivor_name', 'email', 'phone')
            ->distinct()
            ->get();

        return view('users.reporter', compact('reporters'));
    }

    public function storeNote(Request $request, $caseId)
    {
        $request->validate([
            'note' => 'required|string|max:2000',
        ]);

        CaseNote::create([
            'case_id' => $caseId,
            'user_id' => auth()->id(),
            'note'    => $request->note,
        ]);

        return back()->with('success', 'Note added successfully.');
    }
}
