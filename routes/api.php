<?php

use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\GradeController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\HomeworkController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\SolutionController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->name('login');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::name('course.')
    ->group(function () {
        Route::get('/courses', [CourseController::class, 'index'])->name('index');
        Route::get('/course/{course}', [CourseController::class, 'show'])->name('show');
    });

Route::name('group.')
    ->group(function () {
        Route::get('/course/{courseId}/groups', [GroupController::class, 'index'])->name('index');
        Route::get('/group/{group}', [GroupController::class, 'show'])->name('show');
        Route::put('/group/{group}', [GroupController::class, 'update'])->name('update');
        Route::post('/course/{courseId}/group/store', [GroupController::class, 'store'])->name('store');
        Route::delete('group/{group}', [GroupController::class, 'destroy'])->name('destroy');
        Route::put('/group/{groupId}/remove-student', [GroupController::class, 'removeStudent'])->name('removeStudent');
        Route::put('/group/{groupId}/remove-teacher', [GroupController::class, 'removeTeacher'])->name('removeTeacher');
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
        Route::get('/{student}/courses', [StudentController::class, 'getStudentCourses'])->name('getStudentCourses');
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

Route::name('homework.')
    ->group(function () {
        Route::post('/lesson/{lesson}/homework/store', [HomeworkController::class, 'store'])->name('store');
        Route::get('/homework/{homework}', [HomeworkController::class, 'show'])->name('show');
    });

Route::name('solution.')
    ->group(function () {
        Route::get('/solutions', [SolutionController::class, 'index'])->name('index');
        Route::post('/homework/{homeworkId}/solution/store', [SolutionController::class, 'store'])->name('store');
        Route::get('/homework/{homeworkId}/solutions', [SolutionController::class, 'getHomeworkSolutions'])->name('getHomeworkSolutions');
    });

Route::name('grade.')
    ->group(function () {
        Route::post('/grade/{solutionId}/{studentId}', [GradeController::class, 'store'])->name('store');
    });

Route::name('course.')
    ->middleware(['auth:sanctum', 'role:admin|super_admin'])
    ->group(function () {
        Route::post('/course/store', [CourseController::class, 'store'])->name('store');
        Route::put('/course/{course}', [CourseController::class, 'update'])->name('update');
        Route::delete('course/{course}', [CourseController::class, 'destroy'])->name('destroy');
    });

Route::name('student.')
    ->middleware(['auth:sanctum', 'role:super_admin'])
    ->group(function () {
        Route::put('/student/{student}', [StudentController::class, 'update'])->name('update');
        Route::post('/student/store', [StudentController::class, 'store'])->name('store');
        Route::delete('/student/{student}', [StudentController::class, 'destroy'])->name('destroy');
    });
