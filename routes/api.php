<?php

use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\GradeController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\HomeworkController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\SolutionController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('courses')
    ->name('course.')
    ->group(function () {
        Route::middleware(['auth:sanctum'])->group(function () {
            Route::get('/', [CourseController::class, 'index'])->name('index');
            Route::get('/{course}', [CourseController::class, 'show'])->name('show');
        });

        Route::middleware(['auth:sanctum', 'role:super_admin||admin'])->group(function () {
            Route::post('/', [CourseController::class, 'store'])->name('store');
            Route::put('/{course}', [CourseController::class, 'update'])->name('update');
            Route::delete('/{course}', [CourseController::class, 'destroy'])->name('destroy');
        });
    });

Route::prefix('groups')
    ->name('group.')
    ->group(function () {
        Route::middleware(['auth:sanctum'])->group(function () {
            Route::get('/{course}', [GroupController::class, 'index'])->name('index');
            Route::get('/{group}/detail', [GroupController::class, 'show'])->name('show');
        });

        Route::middleware(['auth:sanctum', 'role:super_admin||admin'])->group(function () {
            Route::put('/{group}', [GroupController::class, 'update'])->name('update');
            Route::post('/{course}', [GroupController::class, 'store'])->name('store');
            Route::delete('/{group}', [GroupController::class, 'destroy'])->name('destroy');
            Route::get('/', [GroupController::class, 'getAllGroups'])->name('getAllGroups');
            Route::put('/{group}/remove-student', [GroupController::class, 'removeStudent'])->name('removeStudent');
            Route::put('/{group}/remove-teacher', [GroupController::class, 'removeTeacher'])->name('removeTeacher');
        });
    });

Route::prefix('lessons')
    ->name('lesson.')
    ->group(function () {
        Route::middleware(['auth:sanctum'])->group(function () {
            Route::get('/{course}', [LessonController::class, 'index'])->name('index');
            Route::get('/lesson/{lesson}', [LessonController::class, 'show'])->name('show');
        });

        Route::middleware(['auth:sanctum', 'role:super_admin||admin||teacher'])->group(function () {
            Route::put('/lesson/{lesson}', [LessonController::class, 'update'])->name('update');
            Route::post('/course/{courseId}/lesson/store', [LessonController::class, 'store'])->name('store');
            Route::delete('lesson/{lesson}', [LessonController::class, 'destroy'])->name('destroy');
        });
    });

Route::prefix('students')
    ->name('student.')
    ->group(function () {
        Route::middleware(['auth:sanctum'])->group(function () {
            Route::get('/', [StudentController::class, 'index'])->name('index');
            Route::get('/{student}', [StudentController::class, 'show'])->name('show');
        });

        Route::middleware(['auth:sanctum', 'role:super_admin'])->group(function () {
            Route::post('/store', [StudentController::class, 'store'])->name('store');
            Route::put('/{student}', [StudentController::class, 'update'])->name('update');
            Route::delete('/{student}', [StudentController::class, 'destroy'])->name('destroy');
        });
    });

Route::prefix('teachers')
    ->name('teacher.')
    ->group(function () {
        Route::middleware(['auth:sanctum'])->group(function () {
            Route::get('/', [TeacherController::class, 'index'])->name('index');
            Route::get('/{teacher}', [TeacherController::class, 'show'])->name('show');
        });

        Route::middleware(['auth:sanctum', 'role:super_admin'])->group(function () {
            Route::post('/store', [TeacherController::class, 'store'])->name('store');
            Route::put('/{teacher}', [TeacherController::class, 'update'])->name('update');
            Route::delete('/{teacher}', [TeacherController::class, 'destroy'])->name('destroy');
        });
    });

Route::prefix('homeworks')
    ->name('homework.')
    ->group(function () {
        Route::middleware(['auth:sanctum'])->group(function () {
            Route::get('/homework/{homework}', [HomeworkController::class, 'show'])->name('show');
        });

        Route::middleware(['auth:sanctum', 'role:teacher'])->group(function () {
            Route::post('/lesson/{lesson}/homework/store', [HomeworkController::class, 'store'])->name('store');
        });
    });

Route::prefix('solutions')
    ->name('solution.')
    ->group(function () {
        Route::middleware(['auth:sanctum', 'role:teacher'])->group(function () {
            Route::get('/homework/{homeworkId}/solutions', [SolutionController::class, 'getHomeworkSolutions'])->name('getHomeworkSolutions');
        });

        Route::middleware(['auth:sanctum', 'role:student'])->group(function () {
            Route::post('/homework/{homeworkId}/solution/store', [SolutionController::class, 'store'])->name('store');
        });
    });

Route::prefix('schedules')
    ->name('schedule.')
    ->group(function () {
        Route::middleware(['auth:sanctum'])->group(function () {
            Route::get('/schedule', [ScheduleController::class, 'index'])->name('index');
        });

        Route::middleware(['auth:sanctum', 'role:super_admin||admin'])->group(function () {
            Route::post('/schedule/store', [ScheduleController::class, 'store'])->name('store');
            Route::delete('/schedule/{schedule}', [ScheduleController::class, 'destroy'])->name('destroy');
        });
    });

Route::prefix('grades')
    ->name('grade.')
    ->group(function () {
        Route::middleware(['auth:sanctum', 'role:teacher'])->group(function () {
            Route::post('/grade/{solutionId}/{studentId}', [GradeController::class, 'store'])->name('store');
        });
    });


