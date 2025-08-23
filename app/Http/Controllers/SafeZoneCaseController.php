<?php

namespace App\Http\Controllers;

use App\Models\SafeZoneCase;
use App\Models\User;
use App\Models\Evidence;
use App\Notifications\CaseStatusUpdated;
use App\Notifications\EmergencyAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SafeZoneCaseController extends Controller
{
    // List all cases
    public function index()
    {
        $cases = SafeZoneCase::with(['user', 'agent', 'medical', 'evidences'])->get();
        $agents = User::where('role', 'agent')->get();
        $medicalStaff = User::where('role', 'medical')->get();

        return view('safe_zone_cases.index', compact('cases', 'agents', 'medicalStaff'));
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

        // Notify all RIB agents
        $agents = User::where('role', 'agent')->get();
        foreach ($agents as $agent) {
            $agent->notify(new EmergencyAlert($case));
        }

        return redirect()->route('safe_zone_cases.index')->with('success', 'Case reported successfully.');
    }

    // Show single case
    public function show(SafeZoneCase $safeZoneCase)
    {
        $safeZoneCase->load('user', 'agent', 'medical', 'evidences');
        return view('safe_zone_cases.show', compact('safeZoneCase'));
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
}
