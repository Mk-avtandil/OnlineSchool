<?php

use App\Http\Controllers\Api\SolutionController;
use Illuminate\Support\Facades\Route;

Route::prefix('solutions')
    ->name('solution.')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::middleware(['role:teacher'])->group(function () {
            Route::get('/{homeworkId}', [SolutionController::class, 'getHomeworkSolutions'])->name('getHomeworkSolutions');
        });

        Route::middleware(['role:student'])->group(function () {
            Route::post('/{homeworkId}', [SolutionController::class, 'store'])->name('store');
        });
    });
