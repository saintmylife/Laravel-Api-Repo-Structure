<?php

namespace App\Modules\Base\Domain\Responder;

use App\Modules\Base\Domain\BaseResponder;

abstract class AuthResponder extends BaseResponder
{
    protected function forgetAuthCookie($response)
    {
        return $response->withoutCookie(config('app.access_token_name'))
            ->withoutCookie(config('app.refresh_token_name'));
    }
    protected function authenticated(): void
    {
        $this->response =
            $this->forgetAuthCookie(
                response()->json(
                    ['messages' => 'Login Successfully']
                )
            )->withCookie(cookie(config('app.access_token_name'), $this->payload->getResult()['at'], $this->payload->getResult()['at_expires']))
            ->withCookie(cookie(config('app.refresh_token_name'), $this->payload->getResult()['rt'], $this->payload->getResult()['rt_expires']));
    }
    protected function authLogout(): void
    {
        $this->response =
            $this->forgetAuthCookie(
                response()->json([
                    'status'    => true,
                    'messages'  => 'Logout Successfully',
                ])
            );
    }
    protected function authFailed(): void
    {
        $this->response = abort(
            $this->forgetAuthCookie(
                response()->json([
                    'status'    => false,
                    'messages'  => 'Your login information you entered did not matched our records. Please double check and try again',
                ], 401)
            )
        );
    }
}
