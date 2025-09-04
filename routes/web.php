<?php

use App\Http\Controllers\MedicalReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SafeZoneCaseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::post('/report/cases', [SafeZoneCaseController::class, 'storeCase'])->name('user.reportCases.store');
Route::get('/track-case', [SafeZoneCaseController::class, 'trackCaseForm'])->name('case.track.form');
Route::post('/track-case', [SafeZoneCaseController::class, 'trackCase'])->name('case.track');
Route::post('/case/{id}/add-evidence', [SafeZoneCaseController::class, 'addEvidence'])->name('case.add.evidence');
Route::get('/cases/{id}/download', [SafeZoneCaseController::class, 'downloadPDF'])->name('cases.download');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users', [ProfileController::class, 'indexUser'])->name('users.index');
    Route::post('/users', [ProfileController::class, 'storeUser'])->name('users.store');
    Route::put('/users/{user}', [ProfileController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [ProfileController::class, 'destroyUser'])->name('users.destroy');

    Route::resource('safe-zone-cases', \App\Http\Controllers\SafeZoneCaseController::class);
    Route::get('/safe-zone-cases/{id}', [SafeZoneCaseController::class, 'show'])
    ->name('cases.show');
    Route::get('safe-zone-cases/{id}/evidences', [\App\Http\Controllers\SafeZoneCaseController::class, 'showEvidence'])->name('safe-zone-cases.showEvidence');

    Route::resource('evidences', \App\Http\Controllers\EvidenceController::class);


    Route::post('/cases/{case}/medical-reports', [MedicalReportController::class, 'store'])
        ->name('medical-reports.store');
});

require __DIR__ . '/auth.php';
