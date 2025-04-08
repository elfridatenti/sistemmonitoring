<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;


class Kernel extends HttpKernel {
protected $routeMiddleware = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'role' => \App\Http\Middleware\Role::class,
    // ... middleware lainnya ...
    'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
];

}