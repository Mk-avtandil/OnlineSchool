<?php

use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\CourseGroupsController;
use Illuminate\Support\Facades\Route;

Route::prefix('courses')
    ->name('course.')
    ->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('index');
        Route::get('/{course}/groups', [CourseGroupsController::class, 'group'])->name('group');
    });
