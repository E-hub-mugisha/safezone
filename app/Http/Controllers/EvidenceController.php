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
    public function store(Request $request)
    {
        $request->validate([
            'case_id'      => 'required|exists:safe_zone_cases,id',
            'description' => 'nullable|string|max:255',
            'type'        => 'nullable|string|max:100',
            'file'    => 'required|array',
            'file.*'  => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,mp4|max:20480', // 20MB
        ]);

        $case = SafeZoneCase::findOrFail($request->case_id);

        $uploadedNames = [];

        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $uploadedFile) {
                $path = $uploadedFile->store('file', 'public');

                Evidence::create([
                    'case_id'   => $case->id,
                    'file_path' => $path,
                    'description' => $request->description,
                    'type' => $request->type,
                    // add 'description' or 'status' if your table has them
                ]);

                // keep the original filename for logs/notifications
                $original = $uploadedFile->getClientOriginalName();
                $uploadedNames[] = $original;

                // ✅ log per-file action INSIDE the loop
                TrackingLogService::log(
                    $case->id,
                    auth()->id(),
                    'Evidence Added',
                    "File: {$original}"
                );
            }
        }

        // 🔔 Notify Admin & RIB roles once (include filenames if your Mailable supports it)
        $adminsAndRibs = User::whereIn('role', ['admin', 'rib'])->get();
        foreach ($adminsAndRibs as $user) {
            Mail::to($user->email)->send(
                new \App\Mail\NewEvidenceAddedMail($case, $uploadedNames) // adjust signature if needed
            );
        }

        return back()->with('success', 'Evidence uploaded successfully and admin/RIB notified.');
    }
}
