<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    public function handle($request, Closure $next)
    {
        $domains = [env('DOMAIN_ALLOWED')];
        $origin = $request->server()['HTTP_ORIGIN'] ?? false;
        if ($origin && in_array($origin, $domains)) {
            header('Access-control-Allow-Origin: ' . $origin);
            header('Access-control-Allow-Headers: Origin, Content-Type, Authorization');
            header('Access-control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
        }
        return $next($request);
    }
}
