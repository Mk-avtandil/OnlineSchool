<?php

use App\Http\Controllers\Api\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::prefix('schedules')
    ->name('schedule.')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::middleware(['role:super_admin||admin'])->group(function () {
            Route::post('/', [ScheduleController::class, 'store'])->name('store');
            Route::delete('/{schedule}', [ScheduleController::class, 'destroy'])->name('destroy');
        });

        Route::get('/', [ScheduleController::class, 'index'])->name('index');
    });
