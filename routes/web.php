<?php

use App\Http\Controllers\FilmController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Google Login
Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// --- Films (index public) ---
Route::get('/films', [FilmController::class, 'index'])->name('films.index');

Route::middleware('auth')->group(function () {
    // Abonnement
    Route::get('/subscribe', [SubscriptionController::class, 'show'])->name('subscription.show');
    Route::post('/subscribe/checkout', [SubscriptionController::class, 'checkout'])->name('subscription.checkout');
    Route::get('/subscribe/success', [SubscriptionController::class, 'success'])->name('subscription.success');


    // Films
    Route::get('/films/create', [FilmController::class, 'create'])->name('films.create')->middleware('isAdmin');
    Route::post('/films', [FilmController::class, 'store'])->name('films.store')->middleware('isAdmin');
    Route::get('/films/{film}/edit', [FilmController::class, 'edit'])->name('films.edit')->middleware('isAdmin');
    Route::patch('/films/{film}', [FilmController::class, 'update'])->name('films.update')->middleware('isAdmin');
    Route::delete('/films/{film}', [FilmController::class, 'destroy'])->name('films.destroy')->middleware('isAdmin');

    // Locations
    Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
    Route::get('/locations/create', [LocationController::class, 'create'])->name('locations.create');
    Route::post('/locations', [LocationController::class, 'store'])->name('locations.store');
    Route::get('/locations/{location}', [LocationController::class, 'show'])->name('locations.show');
    Route::get('/locations/{location}/edit', [LocationController::class, 'edit'])->name('locations.edit');
    Route::patch('/locations/{location}', [LocationController::class, 'update'])->name('locations.update');
    Route::delete('/locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');
    Route::post('/locations/{location}/upvote', [LocationController::class, 'upvote'])->name('locations.upvote');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- Films (show public) ---
// Doit être placé APRES /films/create pour éviter une erreur 404
Route::get('/films/{film}', [FilmController::class, 'show'])->name('films.show');

require __DIR__.'/auth.php';
