<?php

namespace MarcioWinicius\LaravelDefaultClasses\Http\Middleware;

use MarcioWinicius\LaravelDefaultClasses\Exceptions\UserNotAuthenticatedException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{

    /**
     * @param \Illuminate\Http\Request $request
     * @param array $guards
     * @throws UserNotAuthenticatedException
     */
    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }

        throw new UserNotAuthenticatedException();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
