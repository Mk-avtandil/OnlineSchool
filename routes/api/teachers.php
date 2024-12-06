<?php

use App\Http\Controllers\Api\TeacherController;
use Illuminate\Support\Facades\Route;

Route::prefix('teachers')
    ->name('teacher.')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::middleware(['role:super_admin'])->group(function () {
            Route::post('/', [TeacherController::class, 'store'])->name('store');
            Route::put('/{teacher}', [TeacherController::class, 'update'])->name('update');
            Route::delete('/{teacher}', [TeacherController::class, 'destroy'])->name('destroy');
        });

        Route::middleware(['role:super_admin||admin'])->group(function () {
            Route::get('/', [TeacherController::class, 'index'])->name('index');
        });

        Route::middleware(['role:teacher'])->group(function () {
            Route::get('/{teacher}/detail', [TeacherController::class, 'detail'])->name('detail');
        });

        Route::get('/{teacher}', [TeacherController::class, 'show'])->name('show');
    });
