<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\Group;
use App\Models\Lesson;
use App\Models\Student;
use App\Policies\CoursePolicy;
use App\Policies\GroupPolicy;
use App\Policies\LessonPolicy;
use App\Policies\StudentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Lesson::class => LessonPolicy::class,
        Group::class => GroupPolicy::class,
        Course::class => CoursePolicy::class,
        Student::class => StudentPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
