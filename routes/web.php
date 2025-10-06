<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicalReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SafeZoneCaseController;
use App\Http\Controllers\EvidenceController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public routes
Route::get('/', function () {
    return view('home');
});

Route::post('/report/cases', [SafeZoneCaseController::class, 'storeCase'])->name('user.reportCases.store');
Route::get('/track-case', [SafeZoneCaseController::class, 'trackCaseForm'])->name('case.track.form');
Route::post('/track-case', [SafeZoneCaseController::class, 'trackCase'])->name('case.track');
Route::post('/case/{id}/add-evidence', [SafeZoneCaseController::class, 'addEvidence'])->name('case.add.evidence');
Route::get('/cases/{id}/download', [SafeZoneCaseController::class, 'downloadPDF'])->name('cases.download');

// Protected routes
Route::middleware('auth')->group(function () {

    // Dashboard (any logged-in user)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile (any logged-in user)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /**
     * ---------------------
     * CASE MANAGEMENT
     * ---------------------
     */

    // View all cases (Agent only)
    Route::get('/safe-zone-cases', function () {
        if (Auth::user()->role == 'user') {
            redirect()->back()->with('error', 'Unauthorized access.');
        }
        return app(SafeZoneCaseController::class)->index();
    })->name('safe-zone-cases.index');

    // Show specific case (Agent & Admin)
    Route::get('/safe-zone-cases/{id}', function ($id) {
        if (!in_array(Auth::user()->role, ['agent', 'admin'])) {
            redirect()->back()->with('error', 'Unauthorized access.');
        }
        return app(SafeZoneCaseController::class)->show($id);
    })->name('safe-zone-cases.show');

    // Create new case (Reporter only)
    Route::post('/safe-zone-cases', function () {
        if (Auth::user()->role !== 'user') {
            redirect()->back()->with('error', 'Unauthorized access.');
        }
        return app(SafeZoneCaseController::class)->storeCase(request());
    })->name('safe-zone-cases.store');
    
    // update specific case (Agent & Admin)
    Route::put('/safe-zone-cases/{id}', function ($id) {
        if (!in_array(Auth::user()->role, ['agent', 'admin'])) {
            redirect()->back()->with('error', 'Unauthorized access.');
        }
        return app(SafeZoneCaseController::class)->update(request(), $id);
    })->name('safe-zone-cases.update');

    // Assign case (Admin only)
    Route::post('/safe-zone-cases/{id}/assign', function ($id) {
        if (!Auth::user()->role !== 'admin') {
            redirect()->back()->with('error', 'Unauthorized access.');
        }
        return app(SafeZoneCaseController::class)->assignCase(request(), $id);
    })->name('cases.assign');

    // Verify case (Admin only)
    Route::post('/safe-zone-cases/{id}/verify', function ($id) {
        if (Auth::user()->role !== 'admin') {
            redirect()->back()->with('error', 'Unauthorized access.');
        }
        return app(SafeZoneCaseController::class)->verifyCase($id);
    })->name('cases.verify');

    // Delete case (Admin only)
    Route::delete('/safe-zone-cases/{id}', function ($id) {
        if (Auth::user()->role !== 'admin') {
            redirect()->back()->with('error', 'Unauthorized access.');
        }
        return app(SafeZoneCaseController::class)->destroy($id);
    })->name('safe-zone-cases.destroy');

    /**
     * ---------------------
     * EVIDENCES
     * ---------------------
     */

    // View evidences (Agent only)
    Route::get('/safe-zone-cases/{id}/evidences', function ($id) {
        if (!in_array(Auth::user()->role, ['reporter', 'agent','admin','medical'])) {
            redirect()->back()->with('error', 'Unauthorized access.');
        }
        return app(SafeZoneCaseController::class)->showEvidence($id);
    })->name('safe-zone-cases.showEvidence');

    // Add evidence (Reporter or Agent)
    Route::post('/safe-zone-cases/{id}/evidences', function ($id) {
        if (!in_array(Auth::user()->role, ['reporter', 'agent','admin','medical'])) {
            redirect()->back()->with('error', 'Unauthorized access.');
        }
        return app(SafeZoneCaseController::class)->addEvidence(request(), $id);
    })->name('safe-zone-cases.addEvidence');

    /**
     * ---------------------
     * CASE NOTES
     * ---------------------
     */
    Route::post('/safe-zone-cases/{case}/notes', function ($case) {
        if (!in_array(Auth::user()->role, ['agent', 'admin'])) {
            redirect()->back()->with('error', 'Unauthorized access.');
        }
        return app(SafeZoneCaseController::class)->storeNote(request(), $case);
    })->name('cases.notes.store');

    /**
     * ---------------------
     * MEDICAL REPORTS
     * ---------------------
     */
    Route::post('/cases/{case}/medical-reports', function ($case) {
        if (Auth::user()->role !== 'medical') {
            redirect()->back()->with('error', 'Unauthorized access.');
        }
        return app(MedicalReportController::class)->store(request(), $case);
    })->name('medical-reports.store');

    /**
     * ---------------------
     * USERS / STAFF MANAGEMENT
     * ---------------------
     */

    // List users (Admin only)
    Route::get('/users', function () {
        if (Auth::user()->role !== 'admin') {
            redirect()->back()->with('error', 'Unauthorized access.');
        }
        return app(ProfileController::class)->indexUser();
    })->name('users.index');

    // Create user (Admin only)
    Route::post('/users', function () {
        if (Auth::user()->role !== 'admin') {
            redirect()->back()->with('error', 'Unauthorized access.');
        }
        return app(ProfileController::class)->storeUser(request());
    })->name('users.store');

    // Update user (Admin only)
    Route::put('/users/{user}', function ($user) {
        if (Auth::user()->role !== 'admin') {
            redirect()->back()->with('error', 'Unauthorized access.');
        }
        return app(ProfileController::class)->updateUser(request(), $user);
    })->name('users.update');

    // Delete user (Admin only)
    Route::delete('/users/{user}', function ($user) {
        if (Auth::user()->role !== 'admin') {
            redirect()->back()->with('error', 'Unauthorized access.');
        }
        return app(ProfileController::class)->destroyUser($user);
    })->name('users.destroy');
});

/**
 * ---------------------
 * EVIDENCE MANAGEMENT
 * ---------------------
 */

// List all evidences (Admin only)
Route::get('/evidences', function () {
    if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'agent' && Auth::user()->role !== 'medical') {
        redirect()->back()->with('error', 'Unauthorized access.');
    }
    return app(\App\Http\Controllers\EvidenceController::class)->index();
})->name('evidences.index');

// Show a single evidence (Admin + Agent + Medical Staff)
Route::get('/evidences/{evidence}', function ($evidence) {
    if (!in_array(Auth::user()->role, ['admin', 'agent', 'medical'])) {
        redirect()->back()->with('error', 'Unauthorized access.');
    }
    return app(\App\Http\Controllers\EvidenceController::class)->show($evidence);
})->name('evidences.show');

// Create evidence (Admin + Agent + Medical Staff)
Route::post('/evidences', function () {
    if (!in_array(Auth::user()->role, ['admin', 'agent', 'medical'])) {
        redirect()->back()->with('error', 'Unauthorized access.');
    }
    return app(\App\Http\Controllers\EvidenceController::class)->store(request());
})->name('evidences.store');

// Update evidence (Admin only)
Route::put('/evidences/{evidence}', function ($evidence) {
    if (Auth::user()->role == 'user') {
        redirect()->back()->with('error', 'Unauthorized access.');
    }
    return app(\App\Http\Controllers\EvidenceController::class)->update(request(), $evidence);
})->name('evidences.update');

// Delete evidence (Admin only)
Route::delete('/evidences/{evidence}', function ($evidence) {
    if (Auth::user()->role !== 'admin') {
        redirect()->back()->with('error', 'Unauthorized access.');
    }
    return app(\App\Http\Controllers\EvidenceController::class)->destroy($evidence);
})->name('evidences.destroy');

Route::get('/agents', [\App\Http\Controllers\ProfileController::class, 'listAgent'])->name('agents.list');
Route::get('/medical-staff', [\App\Http\Controllers\ProfileController::class, 'medicalStaff'])->name('medical-staff.index');
Route::get('/reporters', [\App\Http\Controllers\ProfileController::class, 'listReporter'])->name('reporters.list');
Route::delete('/reporters/{email}', function ($email) {
        if (Auth::user()->role !== 'admin') {
            redirect()->back()->with('error', 'Unauthorized access.');
        }
        return app(ProfileController::class)->destroyReporter($email);
    })->name('reporters.destroy');

Route::get('/my-reported-cases', [\App\Http\Controllers\SafeZoneCaseController::class, 'myReportedCases'])->name('user.reportCases.index');
Route::get('/my-reported-cases/{id}', [\App\Http\Controllers\SafeZoneCaseController::class, 'myReportedCaseShow'])->name('user.reportCases.show');

require __DIR__.'/auth.php';