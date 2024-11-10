<?php

use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\TeacherController;
use Illuminate\Support\Facades\Route;

Route::prefix('courses')
    ->name('course.')
    ->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('index');
        Route::get('/{course}/groups', [CourseController::class, 'getCourseGroups'])->name('getCourseGroups');
        Route::get('/{course}/lessons', [CourseController::class, 'getCourseLessons'])->name('getCourseLessons');
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
