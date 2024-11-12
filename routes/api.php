<?php

use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('course.')
    ->group(function () {
        Route::get('/courses', [CourseController::class, 'index'])->name('index');
        Route::get('/course/{course}', [CourseController::class, 'show'])->name('show');
        Route::put('/course/{course}', [CourseController::class, 'update'])->name('update');
        Route::post('/course/store', [CourseController::class, 'store'])->name('store');
        Route::delete('course/{course}', [CourseController::class, 'destroy'])->name('destroy');
    });

Route::name('group.')
    ->group(function () {
        Route::get('/course/{courseId}/groups', [GroupController::class, 'index'])->name('index');
        Route::get('/group/{group}', [GroupController::class, 'show'])->name('show');
        Route::put('/group/{group}', [GroupController::class, 'update'])->name('update');
        Route::post('/course/{courseId}/group/store', [GroupController::class, 'store'])->name('store');
        Route::delete('group/{group}', [GroupController::class, 'destroy'])->name('destroy');
    });

Route::name('lesson.')
    ->group(function () {
        Route::get('/course/{courseId}/lessons', [LessonController::class, 'index'])->name('index');
        Route::get('/lesson/{lesson}', [LessonController::class, 'show'])->name('show');
        Route::put('/lesson/{lesson}', [LessonController::class, 'update'])->name('update');
        Route::post('/course/{courseId}/lesson/store', [LessonController::class, 'store'])->name('store');
        Route::delete('lesson/{lesson}', [LessonController::class, 'destroy'])->name('destroy');
    });

Route::prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::get('/{student}', [StudentController::class, 'show'])->name('show');
        Route::put('/{student}', [StudentController::class, 'update'])->name('update');
        Route::post('/store', [StudentController::class, 'store'])->name('store');
        Route::delete('/{student}', [StudentController::class, 'destroy'])->name('destroy');
    });

Route::prefix('teacher')
    ->name('teacher.')
    ->group(function () {
        Route::get('/', [TeacherController::class, 'index'])->name('index');
        Route::get('/{teacher}', [TeacherController::class, 'show'])->name('show');
        Route::put('/{teacher}', [TeacherController::class, 'update'])->name('update');
        Route::post('/store', [TeacherController::class, 'store'])->name('store');
        Route::delete('/{teacher}', [TeacherController::class, 'destroy'])->name('destroy');
    });
