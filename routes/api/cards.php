<?php

use App\Http\Controllers\Api\CardController;
use Illuminate\Support\Facades\Route;

Route::prefix('cards')
    ->name('card.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::middleware(['role:student'])->group(function () {
            Route::post('/store', [CardController::class, 'store'])->name('store');
        });
    });
