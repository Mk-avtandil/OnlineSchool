<?php

use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\TeacherController;
use Illuminate\Support\Facades\Route;

Route::prefix('courses')
    ->name('course.')
    ->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('index');
        Route::post('/store', [CourseController::class, 'store'])->name('store');
    });

Route::prefix('groups')
    ->name('group.')
    ->group(function () {
        Route::get('/{courseId}', [GroupController::class, 'index'])->name('index');
        Route::post('/{courseId}/store', [GroupController::class, 'store'])->name('store');
    });

Route::prefix('lessons')
    ->name('lesson.')
    ->group(function () {
        Route::get('/{courseId}', [LessonController::class, 'index'])->name('index');
        Route::post('/{courseId}/store', [LessonController::class, 'store'])->name('store');
    });

Route::prefix('students')
    ->name('student.')
    ->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::post('/store', [StudentController::class, 'store'])->name('store');
    });

Route::prefix('teachers')
    ->name('teacher.')
    ->group(function () {
        Route::get('/', [TeacherController::class, 'index'])->name('index');
        Route::post('/store', [TeacherController::class, 'store'])->name('store');
    });
