<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    public function handle($request, Closure $next)
    {
        $domains = ['http://192.168.1.222:8080'];
        $origin = $request->server()['HTTP_ORIGIN'] ?? false;
        if ($origin && in_array($origin, $domains)) {
            header('Access-control-Allow-Origin: ' . $origin);
            header('Access-control-Allow-Headers: Origin, Content-Type, Authorization');
            header('Access-control-Allow-Methods: *');
        }
        return $next($request);
    }
}
