<?php

use App\Http\Controllers\Api\GroupController;
use Illuminate\Support\Facades\Route;

Route::prefix('groups')
    ->name('group.')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::middleware(['role:super_admin||admin'])->group(function () {
            Route::get('/', [GroupController::class, 'getAllGroups'])->name('getAllGroups');
            Route::patch('/{group}', [GroupController::class, 'update'])->name('update');
            Route::post('/{course}', [GroupController::class, 'store'])->name('store');
            Route::delete('/{group}', [GroupController::class, 'destroy'])->name('destroy');
            Route::put('/{group}/remove-student', [GroupController::class, 'removeStudent'])->name('removeStudent');
            Route::put('/{group}/remove-teacher', [GroupController::class, 'removeTeacher'])->name('removeTeacher');
            Route::post('/{group}/add-students', [GroupController::class, 'addStudents'])->name('addStudents');
            Route::post('/{group}/add-teachers', [GroupController::class, 'addTeachers'])->name('addTeachers');
        });

        Route::get('/{course}', [GroupController::class, 'index'])->name('index');
        Route::get('/{group}/detail', [GroupController::class, 'show'])->name('show');
    });
