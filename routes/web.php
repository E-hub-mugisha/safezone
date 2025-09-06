<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicalReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SafeZoneCaseController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Profiler\Profile;

Route::get('/', function () {
    return view('home');
});

Route::post('/report/cases', [SafeZoneCaseController::class, 'storeCase'])->name('user.reportCases.store');
Route::get('/track-case', [SafeZoneCaseController::class, 'trackCaseForm'])->name('case.track.form');
Route::post('/track-case', [SafeZoneCaseController::class, 'trackCase'])->name('case.track');
Route::post('/case/{id}/add-evidence', [SafeZoneCaseController::class, 'addEvidence'])->name('case.add.evidence');
Route::get('/cases/{id}/download', [SafeZoneCaseController::class, 'downloadPDF'])->name('cases.download');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users', [ProfileController::class, 'indexUser'])->name('users.index');
    Route::post('/users', [ProfileController::class, 'storeUser'])->name('users.store');
    Route::put('/users/{user}', [ProfileController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [ProfileController::class, 'destroyUser'])->name('users.destroy');
    Route::get('/agents', [ProfileController::class, 'listAgent'])->name('agents.list');

    Route::get('/reporters', [SafeZoneCaseController::class, 'listReporter'])->name('reporters.list');
    Route::get('/medical-staff', [ProfileController::class, 'medicalStaff'])->name('medical-staff.index');

    Route::resource('safe-zone-cases', \App\Http\Controllers\SafeZoneCaseController::class);
    Route::get('/safe-zone-cases/{id}', [SafeZoneCaseController::class, 'show'])->name('cases.show');
    Route::get('safe-zone-cases/{id}/evidences', [\App\Http\Controllers\SafeZoneCaseController::class, 'showEvidence'])->name('safe-zone-cases.showEvidence');
    Route::post('safe-zone-case/{id}/evidences', [\App\Http\Controllers\SafeZoneCaseController::class, 'addEvidence'])->name('safe-zone-cases.addEvidence');
    Route::post('/safe-zone-cases/{case}/notes', [SafeZoneCaseController::class, 'storeNote'])->name('cases.notes.store');

    
    Route::resource('evidences', \App\Http\Controllers\EvidenceController::class);


    Route::post('/cases/{case}/medical-reports', [MedicalReportController::class, 'store'])
        ->name('medical-reports.store');
});

require __DIR__ . '/auth.php';
