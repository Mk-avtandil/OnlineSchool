<?php

use App\Http\Controllers\Api\HomeworkController;
use Illuminate\Support\Facades\Route;

Route::prefix('homeworks')
    ->name('homework.')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::middleware(['auth:sanctum', 'role:teacher'])->group(function () {
            Route::post('/{lesson}', [HomeworkController::class, 'store'])->name('store');
        });

        Route::get('/{homework}/detail', [HomeworkController::class, 'show'])->name('show');
    });
