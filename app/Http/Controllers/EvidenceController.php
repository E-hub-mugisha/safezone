<?php

namespace App\Http\Controllers;

use App\Models\Evidence;
use App\Models\SafeZoneCase;
use App\Models\User;
use App\Services\TrackingLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EvidenceController extends Controller
{
    public function index()
    {
        $evidences = Evidence::with('case')->get();
        return view('evidences.index', compact('evidences'));
    }
    public function store(Request $request, $id)
    {
        $case = SafeZoneCase::findOrFail($id);

        $request->validate([
            'evidences.*' => 'file|mimes:jpg,png,pdf,docx,mp4|max:20480'
        ]);

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
            'Evidence Added',
            "File: {$file->getClientOriginalName()}"
        );


        // 🔔 Notify Admin & RIB roles
        $adminsAndRibs = User::whereIn('role', ['admin', 'rib'])->get();

        foreach ($adminsAndRibs as $user) {
            Mail::to($user->email)->send(new \App\Mail\NewEvidenceAddedMail($case));
        }

        return back()->with('success', 'Evidence uploaded successfully and admin/RIB notified.');
    }
}
