<?php

namespace App\Http\Controllers;

use App\Models\MedicalReport;
use App\Models\SafeZoneCase;
use App\Notifications\MedicalReportAdded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class MedicalReportController extends Controller
{
    public function store(Request $request, $caseId)
    {
        $request->validate([
            'report' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
        ]);

        $case = SafeZoneCase::findOrFail($caseId);

        // upload file if available
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('medical_reports', 'public');
        }

        $report = MedicalReport::create([
            'case_id' => $case->id,
            'medical_id' => auth()->id(),
            'report' => $request->report,
            'file_path' => $filePath,
        ]);

        // Notify survivor
        Notification::route('mail', $case->email)
            ->notify(new MedicalReportAdded($report));

        return redirect()->back()->with('success', 'Medical report added and survivor notified.');
    }
}
