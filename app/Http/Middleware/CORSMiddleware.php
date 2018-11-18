<?php

namespace App\Http\Middleware;

use Closure;

class CORSMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $origin = $request->server('HTTP_ORIGIN') ?? '*'; // todo: 暂时设置，用于开发调试，待修改。
        $response = $next($request);
        return $response->withHeaders([
            'Access-Control-Allow-Origin' => 'http://www.w3school.com.cn',
            'Access-Control-Allow-Headers' => 'Origin, Content-Type, Accept, Authorization, x-requested-with',
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, PATCH, DELETE, OPTIONS'
        ]);
    }
}
