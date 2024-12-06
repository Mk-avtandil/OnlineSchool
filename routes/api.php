<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

require base_path('routes/api/courses.php');
require base_path('routes/api/groups.php');
require base_path('routes/api/lessons.php');
require base_path('routes/api/students.php');
require base_path('routes/api/teachers.php');
require base_path('routes/api/homeworks.php');
require base_path('routes/api/solutions.php');
require base_path('routes/api/schedules.php');
require base_path('routes/api/grades.php');
require base_path('routes/api/payments.php');
require base_path('routes/api/cards.php');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::get('/user', [AuthenticatedSessionController::class, 'user'])->name('user')->middleware(['auth:sanctum']);

