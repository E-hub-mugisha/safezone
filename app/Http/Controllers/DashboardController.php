<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\SafeZoneCase;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Cases grouped by type
        $casesByType = SafeZoneCase::selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type');

        // Cases grouped by status
        $casesByStatus = SafeZoneCase::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        // Cases grouped by location (top 5 only)
        $casesByLocation = SafeZoneCase::selectRaw('location, COUNT(*) as count')
            ->whereNotNull('location')
            ->groupBy('location')
            ->orderByDesc('count')
            ->limit(5)
            ->pluck('count', 'location');

        return view('dashboard.index', compact('casesByType', 'casesByStatus', 'casesByLocation'));
    }

    public function indexResource()
    {
        $resources = Resource::all();
        return view('resources.index', compact('resources'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:article,video,faq',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:mp4,pdf,docx|max:20480'
        ]);

        $path = $request->hasFile('file') 
            ? $request->file('file')->store('resources','public') 
            : null;

        Resource::create([
            'title' => $request->title,
            'type' => $request->type,
            'content' => $request->content,
            'file_path' => $path
        ]);

        return back()->with('success','Resource added successfully.');
    }
}
