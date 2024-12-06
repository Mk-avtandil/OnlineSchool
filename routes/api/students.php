<?php

use App\Http\Controllers\Api\StudentController;
use Illuminate\Support\Facades\Route;

Route::prefix('students')
    ->name('student.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::middleware(['role:super_admin'])->group(function () {
            Route::post('/', [StudentController::class, 'store'])->name('store');
            Route::put('/{student}', [StudentController::class, 'update'])->name('update');
            Route::delete('/{student}', [StudentController::class, 'destroy'])->name('destroy');
            Route::get('/payments', [StudentController::class, 'getAllStudentsWithPayments'])->name('getAllStudentsWithPayments');
        });

        Route::middleware(['role:super_admin||admin'])->group(function () {
            Route::get('/', [StudentController::class, 'index'])->name('index');
        });

        Route::middleware(['role:student'])->group(function () {
            Route::get('/{student}/detail', [StudentController::class, 'detail'])->name('detail');
        });

        Route::get('/{student}', [StudentController::class, 'show'])->name('show');
    });
