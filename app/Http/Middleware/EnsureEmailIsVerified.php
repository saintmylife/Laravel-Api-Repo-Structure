<?php

namespace App\Http\Middleware;

use Closure;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Auth\Api\Responder\AuthResponder;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|null
     */
    public function handle($request, Closure $next)
    {
        if (
            !$request->user() ||
            ($request->user() instanceof MustVerifyEmail &&
                !$request->user()->hasVerifiedEmail())
        ) {
            return (resolve(AuthResponder::class))->__invoke(new Payload(Payload::STATUS_AUTH_NOT_VERIFIED));
        }

        return $next($request);
    }
}
