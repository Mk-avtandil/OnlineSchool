<?php

use App\Http\Controllers\Api\GradeController;
use Illuminate\Support\Facades\Route;

Route::prefix('grades')
    ->name('grade.')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::middleware(['role:teacher'])->group(function () {
            Route::post('/{solutionId}/{studentId}', [GradeController::class, 'store'])->name('store');
        });
    });
