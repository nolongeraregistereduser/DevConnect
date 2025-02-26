<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ViewProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/profile/view', [ViewProfileController::class, 'showOwn'])->name('profile.view.own');
    Route::get('/profile/{id}/view', [ViewProfileController::class, 'show'])->name('profile.view');
});

require __DIR__.'/auth.php';
