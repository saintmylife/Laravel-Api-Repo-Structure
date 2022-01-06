<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Illuminate\Support\Facades\Cookie;
use PHPOpenSourceSaver\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{
    protected $accessTokenTTL;
    protected $accessTokenName;
    protected $refreshTokenTTL;
    protected $refreshTokenName;

    public function __construct()
    {
        $this->accessTokenTTL = config('jwt.ttl');
        $this->accessTokenName = config('app.access_token_name');
        $this->refreshTokenTTL = config('jwt.refresh_ttl');
        $this->refreshTokenName = config('app.refresh_token_name');
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // if no token, return 401, user must login
        if (!$request->hasCookie($this->accessTokenName) && !$request->hasCookie($this->refreshTokenName)) {
            return response()->json(['status' => 'Authorization Token not found'], 401);
        }
        // if AT is provided, set authorization header, and next
        if ($request->hasCookie($this->accessTokenName)) {
            $this->parseTokenAndAuthenticate($request, $request->cookie($this->accessTokenName));
            return $next($request);
        }
        // if AT is no longer exist (because expired), set RT for authorization header
        $this->parseTokenAndAuthenticate($request, $request->cookie($this->refreshTokenName));
        // refresh token to get AT again
        $token = $this->renewToken();
        // return previous response with new token
        return $next($request)->withCookie(Cookie::forget($this->accessTokenName))
            ->withCookie(Cookie::forget($this->refreshTokenName))
            ->withCookie(cookie($this->accessTokenName, $token['at'], $this->accessTokenTTL))
            ->withCookie(cookie($this->refreshTokenName, $token['rt'], $this->refreshTokenTTL));
    }
    /**
     * Handle parse Token and Authenticated.
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
    /**
     * Renew token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Token
     * @return response
     */
    protected function renewToken()
    {
        $token['at'] = JWTAuth::refresh(JWTAuth::getToken());
        // reset RT
        $refreshed = JWTAuth::factory()->setTTL($this->refreshTokenTTL)->make()->toArray();
        $token['rt'] = JWTAuth::getJWTProvider()->encode($refreshed);
        // return previous response with new token
        return $token;
    }
}
