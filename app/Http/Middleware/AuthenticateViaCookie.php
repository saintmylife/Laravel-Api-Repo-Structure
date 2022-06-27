<?php

namespace App\Http\Middleware;

use App\Modules\V1\Auth\Domain\Service\AuthRefresh;
use Closure;

class AuthenticateViaCookie extends Authenticate
{
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
        return parent::handle($request, $next, ...$guards);
    }

    protected function checkAndSetToken($request)
    {
        if (
            !$request->hasCookie((config('app-config.token.access.name'))) &&
            $request->hasCookie((config('app-config.token.refresh.name')))
        ) {
            $refresh = (resolve(AuthRefresh::class))->__invoke();
            if ($refresh->getStatus() == 'AUTH_LOGGED_IN') {
                cookie()->getQueuedCookies();
                $request->headers->add([
                    'Authorization' => 'Bearer ' . $refresh->getResult()['token']
                ]);
            };
        }
        if ($request->hasCookie(config('app-config.token.access.name'))) {
            $request->headers->add([
                'Authorization' => 'Bearer ' . $request->cookie(config('app-config.token.access.name'))
            ]);
        }

        return;
    }
}
