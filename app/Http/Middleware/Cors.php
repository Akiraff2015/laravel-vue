<?php

namespace App\Http\Middleware;
use Closure;

class Cors {
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */

    public function handle($request, Closure $next) {
        header("Access-Control-Allow-ORIGIN: *");
        $headers = [
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, Origin, Authorization'
        ];

        $response = $next($request);
        foreach($headers as $key => $value) {
            $response->header($key, $value);
            return $response;
        }
    }
}