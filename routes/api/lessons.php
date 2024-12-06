<?php

use App\Http\Controllers\Api\LessonController;
use Illuminate\Support\Facades\Route;

Route::prefix('lessons')
    ->name('lesson.')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::middleware(['role:super_admin||admin||teacher'])->group(function () {
            Route::put('/{lesson}', [LessonController::class, 'update'])->name('update');
            Route::post('/{course}', [LessonController::class, 'store'])->name('store');
            Route::delete('/{lesson}', [LessonController::class, 'destroy'])->name('destroy');
        });

        Route::get('/{course}', [LessonController::class, 'index'])->name('index');
        Route::get('/{lesson}/detail', [LessonController::class, 'show'])->name('show');
    });
