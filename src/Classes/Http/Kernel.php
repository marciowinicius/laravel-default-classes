<?php

namespace MarcioWinicius\LaravelDefaultClasses\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \MarcioWinicius\LaravelDefaultClasses\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \MarcioWinicius\LaravelDefaultClasses\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \MarcioWinicius\LaravelDefaultClasses\Http\Middleware\TrustProxies::class,
        \MarcioWinicius\LaravelDefaultClasses\Http\Middleware\AlwaysExpectsJson::class,
        \MarcioWinicius\LaravelDefaultClasses\Http\Middleware\Cors::class,

    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \MarcioWinicius\LaravelDefaultClasses\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \MarcioWinicius\LaravelDefaultClasses\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

//        'api' => [
////            'throttle:60,1',
//            'bindings',
//        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \MarcioWinicius\LaravelDefaultClasses\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'cors'  =>  \MarcioWinicius\LaravelDefaultClasses\Http\Middleware\Cors::class,
        'guest' => \MarcioWinicius\LaravelDefaultClasses\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'needsPermission' => \Artesaos\Defender\Middlewares\NeedsPermissionMiddleware::class,
        'needsRole' => \Artesaos\Defender\Middlewares\NeedsRoleMiddleware::class,
    ];

    /**
     * The priority-sorted list of middleware.
     *
     * This forces the listed middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \MarcioWinicius\LaravelDefaultClasses\Http\Middleware\Authenticate::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];
}
