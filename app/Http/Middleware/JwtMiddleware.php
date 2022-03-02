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
        // get AT and RT name from config
        $atTokenName = config('app.access_token_name');
        $rtTokenName = config('app.refresh_token_name');
        // if no token, return 401, user must login
        if (!$request->hasCookie($atTokenName) && !$request->hasCookie($rtTokenName)) {
            return response()->json(['status' => 'Authorization Token not found'], 401);
        }
        // if AT is provided, set authorization header, and next
        if ($request->hasCookie($atTokenName)) {
            $this->parseTokenAndAuthenticate($request, $request->cookie($atTokenName));
            return $next($request);
        }
        // if AT is no longer exist (because expired), set RT for authorization header
        $this->parseTokenAndAuthenticate($request, $request->cookie($rtTokenName));
        // refresh token to get AT again
        $at = JWTAuth::refresh(JWTAuth::getToken());
        // reset RT
        $refreshed = auth()->factory()->setTTL(config('jwt.ttl') * 24 * 7)->make()->toArray();
        $rt = JWTAuth::getJWTProvider()->encode($refreshed);
        // return previous response with new token
        return $next($request)->withCookie(Cookie::forget($atTokenName))
            ->withCookie(Cookie::forget($rtTokenName))
            ->withCookie(cookie($atTokenName, $at, config('jwt.ttl')))
            ->withCookie(cookie($rtTokenName, $rt, auth()->factory()->getTTL()));
    }
    /**
     * Handle authorization.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Token
     * @return response
     */
    protected function parseTokenAndAuthenticate($request, $token)
    {
        $request->headers->add(['Authorization' => 'Bearer ' . $token]);
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            return response()->json(['messages' => 'Invalid Token or Expired Token'], 403)
                ->withCookie(Cookie::forget(config('app.access_token_name')))
                ->withCookie(Cookie::forget(config('app.refresh_token_name')));
        }
    }
}
