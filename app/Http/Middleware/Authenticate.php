<?php

namespace App\Http\Middleware;

use App\Modules\Auth\Traits\PassportConfig;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Modules\Common\Domain\AuthPayload;
use App\Modules\Common\Middleware\{JwtMiddlewareRespond, JwtMiddlewareContract};
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use App\Modules\Common\Domain\Payload;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Authenticate extends Middleware implements JwtMiddlewareContract
{
    use PassportConfig;
    private $respond;
    private $accessTokenTTL;
    private $accessTokenName;
    private $refreshTokenTTL;
    private $refreshTokenName;
    private $newToken;
    /** From Parent */
    protected $auth;

    public function __construct(AuthFactory $auth, JwtMiddlewareRespond $respond)
    {
        parent::__construct($auth);
        $this->respond = $respond;
        $this->accessTokenTTL = config('app-auth.access_token_exp');
        $this->accessTokenName = config('app-auth.access_token_name');
        $this->refreshTokenTTL = config('app-auth.refresh_token_exp');
        $this->refreshTokenName = config('app-auth.refresh_token_name');
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, \Closure $next, ...$guards)
    {
        $this->checkAndSetToken($request);
        $this->authenticate($request, $guards);

        return $this->handleCookie($request, $next);
    }
    /**
     * Handle Queue Cookie
     */
    private function handleCookie($request, \Closure $next)
    {
        Cookie::queue($this->accessTokenName, $this->newToken['at'], $this->accessTokenTTL);
        Cookie::queue($this->refreshTokenName, $this->newToken['rt'], $this->refreshTokenTTL);
        $response = $next($request);
        $queueCookie = Cookie::getQueuedCookies();
        foreach ($queueCookie as $cookie) {
            $response->headers->setCookie($cookie);
        }
        return $response;
    }
    /**
     * Handle an unauthenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     */
    protected function unauthenticated($request, array $guards)
    {
        $this->returnPayload(AuthPayload::STATUS_AUTH_TOKEN_NOT_FOUND);
    }
    /**
     * Check and set the token from cookie
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function checkAndSetToken($request)
    {
        if (!$request->hasCookie($this->accessTokenName) && !$request->hasCookie($this->refreshTokenName)) return;
        // if AT is provided, set authorization header
        if ($request->hasCookie($this->accessTokenName)) {
            $this->setAuthorizationHeader($request, $request->cookie($this->accessTokenName));
            $this->newToken['at'] = $request->cookie($this->accessTokenName);
            $this->newToken['rt'] = $request->cookie($this->refreshTokenName);
        } elseif ($request->hasCookie($this->refreshTokenName)) {
            // if AT is no longer exist (because expired), renew
            $this->renewToken($request);
        }
    }
    /**
     * renew token
     *
     * @param  \Illuminate\Http\Request;  $request
     * @param  string  $token
     * @return mixed
     */
    private function renewToken($request)
    {
        try {
            $auth = Http::asForm()->post(
                $this->oAuthUrl(),
                $this->oAuthFormData('refresh_token', [
                    'refresh_token' => $request->cookie($this->refreshTokenName),
                ])
            );
            if ($auth->status() != 200) {
                throw new \Exception($auth->json()['message']);
            }
        } catch (\Exception $e) {
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/passport.log'),
            ])->info($e->getMessage());
            return $this->returnPayload(AuthPayload::STATUS_AUTH_TOKEN_INVALID);
        }
        $auth = $auth->json();
        $this->newToken['at'] = $auth['access_token'];
        $this->newToken['rt'] = $auth['refresh_token'];
        $this->setAuthorizationHeader($request, $auth['access_token']);
    }
    /**
     * set authorization based on cookie
     *
     * @param  \Illuminate\Http\Request;  $request
     * @param  string  $token
     * @return mixed
     */
    public function setAuthorizationHeader($request, $token)
    {
        $request->headers->add(['Authorization' => 'Bearer ' . $token]);
    }
    /**
     * Return response to user
     *
     * @param string  $status
     * @return Symfony\Component\HttpFoundation\Response;
     */
    public function returnPayload($status)
    {
        $payload = new Payload($status);
        return $this->respond->__invoke($payload);
    }
}
