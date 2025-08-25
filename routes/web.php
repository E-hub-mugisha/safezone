<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SafeZoneCaseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/cases', [SafeZoneCaseController::class, 'storeCase'])->name('user.safe_zone_cases.store');

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
    Route::get('safe-zone-cases/{id}/evidences', [\App\Http\Controllers\SafeZoneCaseController::class, 'showEvidence'])->name('safe-zone-cases.showEvidence');

    Route::resource('evidences', \App\Http\Controllers\EvidenceController::class);
});

require __DIR__.'/auth.php';
