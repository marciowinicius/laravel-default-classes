<?php
namespace MarcioWinicius\LaravelDefaultClasses\Http\Middleware;

use Closure;

class AlwaysExpectsJson
{
    public function handle($request, Closure $next)
    {
        if(array_key_exists('REQUEST_URI', $_SERVER) and stripos($_SERVER["REQUEST_URI"],'/api/doc')===false){
            $request->headers->add(['Accept' => 'application/json']);
        }
        return $next($request);
    }
}
