<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Illuminate\Support\Facades\Cookie;

class JwtMiddleware
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

        if (!$request->hasCookie(config('app.access_token_name')) && !$request->hasCookie(config('app.refresh_token_name'))) {
            return response()->json(['status' => 'Authorization Token not found'], 401);
        }

        if ($request->hasCookie(config('app.access_token_name'))) {
            $request->headers->add(['Authorization' => 'Bearer ' . $request->cookie(config('app.access_token_name'))]);
            JWTAuth::parseToken()->authenticate();
            return $next($request);
        }

        $setRtCookie = JWTAuth::setToken($request->cookie(config('app.refresh_token_name')));
        $setRtCookie->authenticate();
        $at = $setRtCookie->refresh();
        $at_expires =  JWTAuth::factory()->getTTL();
        $refreshed = JWTAuth::factory()->setTTL($at_expires * 24 * 7)->make()->toArray();
        $rt = JWTAuth::getJWTProvider()->encode($refreshed);
        return response()->json(['messages' => 'Reauth'])
            ->withCookie(Cookie::forget(config('app.access_token_name')))
            ->withCookie(Cookie::forget(config('app.refresh_token_name')))
            ->withCookie(cookie(config('app.access_token_name'), $at, $at_expires))
            ->withCookie(cookie(config('app.refresh_token_name'), $rt, JWTAuth::factory()->getTTL()));
    }
}
