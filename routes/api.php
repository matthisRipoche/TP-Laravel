<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\FilmLocationController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [ApiAuthController::class, 'login']);

Route::middleware(['auth:api', 'subscribed'])->group(function () {
    Route::get('/films/{film}/locations', [FilmLocationController::class, 'index']);
});
