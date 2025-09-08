<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\BuildingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('buildings.index');
});

Route::get('/dashboard', function () {
    return redirect()->route('buildings.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Building management routes
Route::middleware('auth')->group(function () {
    Route::resource('buildings', BuildingController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
