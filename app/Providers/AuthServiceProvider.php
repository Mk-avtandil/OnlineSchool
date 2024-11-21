<?php

namespace App\Providers;

use App\Models\Group;
use App\Models\Lesson;
use App\Policies\GroupPolicy;
use App\Policies\LessonPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Lesson::class => LessonPolicy::class,
        Group::class => GroupPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
