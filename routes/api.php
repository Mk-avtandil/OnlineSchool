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
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware(['auth:sanctum'])->name('logout');
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('course.')
    ->group(function () {
        Route::get('/courses', [CourseController::class, 'index'])->name('index');
        Route::get('/course/{course}', [CourseController::class, 'show'])->name('show');
    });

Route::name('group.')
    ->group(function () {
        Route::get('/course/{courseId}/groups', [GroupController::class, 'index'])->name('index');
        Route::get('/group/{groupId}/teachers', [GroupController::class, 'getTeachersForGroup'])->name('getTeachersForGroup');
        Route::get('/group/{group}', [GroupController::class, 'show'])->name('show');
    });

Route::name('lesson.')
    ->group(function () {
        Route::get('/course/{courseId}/lessons', [LessonController::class, 'index'])->name('index');
        Route::get('/lesson/{lesson}', [LessonController::class, 'show'])->name('show');
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
    });

Route::name('homework.')
    ->group(function () {
        Route::get('/homework/{homework}', [HomeworkController::class, 'show'])->name('show');
    });

Route::name('schedule.')
    ->group(function () {
        Route::get('/schedule', [ScheduleController::class, 'index'])->name('index');
    });

// Super admin
Route::middleware(['auth:sanctum', 'role:super_admin'])
    ->group(function () {
        Route::prefix('student')
            ->name('student.')
            ->group(function () {
                Route::post('/store', [StudentController::class, 'store'])->name('store');
                Route::put('/{student}', [StudentController::class, 'update'])->name('update');
                Route::delete('/{student}', [StudentController::class, 'destroy'])->name('destroy');
            });

        Route::prefix('teacher')
            ->name('teacher.')
            ->group(function () {
                Route::post('/store', [TeacherController::class, 'store'])->name('store');
                Route::put('/{teacher}', [TeacherController::class, 'update'])->name('update');
                Route::delete('/{teacher}', [TeacherController::class, 'destroy'])->name('destroy');
            });
    });

// Super admin && Admin
Route::middleware(['auth:sanctum', 'role:super_admin||admin'])
    ->group(function () {
        Route::prefix('course')
            ->name('course.')
            ->group(function () {
                Route::post('/store', [CourseController::class, 'store'])->name('store');
                Route::put('/{course}', [CourseController::class, 'update'])->name('update');
                Route::delete('/{course}', [CourseController::class, 'destroy'])->name('destroy');
            });

        Route::name('group.')
            ->group(function () {
                Route::put('/group/{group}', [GroupController::class, 'update'])->name('update');
                Route::post('/course/{courseId}/group/store', [GroupController::class, 'store'])->name('store');
                Route::delete('/group/{group}', [GroupController::class, 'destroy'])->name('destroy');
                Route::get('/groups/', [GroupController::class, 'getAllGroups'])->name('getAllGroups');
                Route::put('/group/{groupId}/remove-student', [GroupController::class, 'removeStudent'])->name('removeStudent');
                Route::put('/group/{groupId}/remove-teacher', [GroupController::class, 'removeTeacher'])->name('removeTeacher');
            });

        Route::name('schedule.')
            ->group(function () {
                Route::post('/schedule/store', [ScheduleController::class, 'store'])->name('store');
                Route::delete('/schedule/{schedule}', [ScheduleController::class, 'destroy'])->name('destroy');
            });
    });

// Super admin && Admin && Teacher
Route::middleware(['auth:sanctum', 'role:super_admin||admin||teacher'])
    ->group(function () {
        Route::name('lesson.')
            ->group(function () {
                Route::put('/lesson/{lesson}', [LessonController::class, 'update'])->name('update');
                Route::post('/course/{courseId}/lesson/store', [LessonController::class, 'store'])->name('store');
                Route::delete('lesson/{lesson}', [LessonController::class, 'destroy'])->name('destroy');
            });
    });

// Teacher
Route::middleware(['auth:sanctum', 'role:teacher'])
    ->group(function () {
        Route::name('homework.')
            ->group(function () {
                Route::post('/lesson/{lesson}/homework/store', [HomeworkController::class, 'store'])->name('store');
            });

        Route::name('grade.')
            ->group(function () {
                Route::post('/grade/{solutionId}/{studentId}', [GradeController::class, 'store'])->name('store');
            });

        Route::name('solution.')
            ->group(function () {
                Route::get('/homework/{homeworkId}/solutions', [SolutionController::class, 'getHomeworkSolutions'])->name('getHomeworkSolutions');
            });
    });

// Student
Route::middleware(['auth:sanctum', 'role:student'])
    ->group(function () {
        Route::name('solution.')
            ->group(function () {
                Route::post('/homework/{homeworkId}/solution/store', [SolutionController::class, 'store'])->name('store');
            });
    });
