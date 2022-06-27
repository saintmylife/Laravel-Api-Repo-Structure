<?php

namespace App\Http\Middleware;

use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Auth\Api\Responder\AuthResponder;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RequirePassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (empty($request->header(config('app-config.password_confirmation')))) {
            return (resolve(AuthResponder::class))->__invoke(new Payload(Payload::STATUS_AUTH_PASSWORD_CONFIRM, [
                'password' => 'Please enter your password'
            ]));
        }
        if (!Hash::check($request->header(config('app-config.password_confirmation')), auth()->user()->getAuthPassword())) {
            return (resolve(AuthResponder::class))->__invoke(new Payload(Payload::STATUS_AUTH_PASSWORD_CONFIRM, [
                'password' => 'Incorrect password'
            ]));
        }
        $request->headers->remove(config('app-config.password_confirmation'));
        return $next($request);
    }
}
