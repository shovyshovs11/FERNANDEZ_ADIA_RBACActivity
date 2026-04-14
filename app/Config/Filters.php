<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use App\Filters\AuthFilter;
use App\Filters\GuestFilter;
use App\Filters\StudentFilter;
use App\Filters\TeacherFilter;
use App\Filters\AdminFilter;
use App\Filters\CoordinatorFilter;

class Filters extends BaseFilters
{
    public array $aliases = [
        'csrf' => CSRF::class,
        'toolbar' => DebugToolbar::class,
        'auth' => AuthFilter::class,
        'guest' => GuestFilter::class,
        'student' => StudentFilter::class,
        'teacher' => TeacherFilter::class,
        'admin' => AdminFilter::class,
        'coordinator' => CoordinatorFilter::class,
        'auth|student' => [AuthFilter::class, StudentFilter::class],
        'auth|teacher' => [AuthFilter::class, TeacherFilter::class],
        'auth|admin' => [AuthFilter::class, AdminFilter::class],
        'auth|coordinator' => [AuthFilter::class, CoordinatorFilter::class],

        //Bearer token filter
        'api_auth' => \App\Filters\ApiAuthFilter::class,
    ];

    public array $required = [
        'before' => [],
        'after' => [
            'toolbar',
        ],
    ];

    public array $globals = [
        'before' => [],
        'after' => [],
    ];

    public array $methods = [];

    public array $filters = [
        'guest' => ['before' => ['login', 'register']],
    ];
}