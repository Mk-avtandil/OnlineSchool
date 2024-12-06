<?php

use App\Http\Controllers\Api\CourseController;
use Illuminate\Support\Facades\Route;

Route::prefix('courses')
    ->name('course.')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::middleware(['role:super_admin||admin'])->group(function () {
            Route::post('/', [CourseController::class, 'store'])->name('store');
            Route::put('/{course}', [CourseController::class, 'update'])->name('update');
            Route::delete('/{course}', [CourseController::class, 'destroy'])->name('destroy');
            Route::get('/{course}/statistics', [CourseController::class, 'statistics'])->name('statistics');
            Route::get('/all', [CourseController::class, 'getAllCourses'])->name('getAllCourses');
        });

        Route::get('/', [CourseController::class, 'index'])->name('index');
        Route::get('/{course}', [CourseController::class, 'show'])->name('show');
    });

