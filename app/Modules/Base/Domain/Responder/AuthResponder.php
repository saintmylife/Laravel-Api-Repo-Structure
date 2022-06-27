<?php

namespace App\Modules\Base\Domain\Responder;

trait AuthResponder
{
    protected function authLoggedIn(): void
    {
        $this->response = response()->json([
            'status' => true,
            'messages' => 'Login Successfully !!',
            'access_token' => $this->payload->getResult()['token']
        ]);
    }
    protected function authLoggedOut(): void
    {
        $this->response = response()->json([
            'status' => true,
            'messages' => 'Logout Successfully !!',
        ]);
    }
    protected function authExpired(): void
    {
        $this->response = response()->json([
            'status' => false,
            'messages' => 'Your session is expired, please login again',
        ], 401);
    }
    protected function authNotValid(): void
    {
        $this->response = response()->json([
            'status' => false,
            'messages' => $this->payload->getResult()['messages'] ?? 'The Information you entered did not match any records. Please double check and try again'
        ], empty($this->payload->getResult()['messages']) ? 400 : 403);
    }
    protected function authNotVerified(): void
    {
        $this->response = response()->json([
            'status' => false,
            'messages' => 'Please verify your account first'
        ], 403);
    }
    protected function authVerifyOtpAlready(): void
    {
        $this->response = response()->json([
            'status' => false,
            'messages' => 'Your account is already verified'
        ], 400);
    }
    protected function authVerifyOtpExpired(): void
    {
        $this->response = response()->json([
            'status' => false,
            'messages' => 'Expired OTP Code, please generate a new one'
        ], 400);
    }
    protected function authVerifyOtpSuccess(): void
    {
        $this->response = response()->json([
            'status' => true,
            'messages' => 'Your account is verified'
        ]);
    }
    protected function authSendEmail(): void
    {
        $this->response = response()->json([
            'status' => true,
            'messages' => 'Please check your email'
        ]);
    }
    protected function authResetPasswordFailed(): void
    {
        $this->response = response()->json([
            'status' => false,
            'messages' => 'Failed to reset password, either credentials not valid or expired token'
        ], 400);
    }
    protected function authResetPasswordSuccess(): void
    {
        $this->response = response()->json([
            'status' => true,
            'messages' => 'Success resetting your password, please relogin'
        ]);
    }
    protected function authPasswordConfirm(): void
    {
        $this->response = response()->json([
            'status' => false,
            'messages' => [
                'password' => $this->payload->getResult()['password']
            ]
        ], 422);
    }
    protected function authChangePasswordSuccess(): void
    {
        $this->response = response()->json([
            'status' => true,
            'messages' => 'Success change your password'
        ]);
    }
    protected function unauthorized(): void
    {
        $this->response = response()->json([
            'status' => false,
            'messages' => 'Unauthorized'
        ], 401);
    }
    protected function authFound(): void
    {
        $this->response = response()->json([
            'status' => true,
            'messages' => 'Credentials Found'
        ]);
    }
    protected function forbidden(): void
    {
        $this->response = response()->json([
            'status' => false,
            'messages' => 'Forbidden'
        ], 403);
    }
    protected function notOwner(): void
    {
        $this->response = abort(
            response()->json(
                [
                    'status' => false,
                    'messages' => 'Cant modify, You are not own this resource'
                ],
                403
            )
        );
    }
    protected function protectedResource(): void
    {
        $this->response = abort(response()->json(['messages' => 'Cant modify protected resource'], 403));
    }
}
