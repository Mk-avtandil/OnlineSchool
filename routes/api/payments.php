<?php

use App\Http\Controllers\Api\PaymentController;
use Illuminate\Support\Facades\Route;

Route::prefix('payments')
    ->name('payment.')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::middleware(['role:student'])->group(function () {
            Route::post('/{courseId}', [PaymentController::class, 'store'])->name('store');
        });
    });
