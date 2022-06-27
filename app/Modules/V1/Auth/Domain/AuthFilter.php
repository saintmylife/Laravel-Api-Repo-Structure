<?php

namespace App\Modules\V1\Auth\Domain;

use App\Modules\V1\User\Domain\UserFilter;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AuthFilter extends UserFilter
{
    public function forLoginCheck(array $data): bool
    {
        $this->setRules([
            'username' => ['required', 'string']
        ]);
        return $this->validate($data);
    }
    public function forLogin(array $data): bool
    {
        $this->setMessages([
            'client_id.exists' => 'No valid authentication method, plase check your configuration'
        ]);
        $this->setRules([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'client_id' => ['nullable', 'integer', 'exists:oauth_clients,id']
        ]);
        return $this->validate($data);
    }
    public function forRegister($data): bool
    {
        $this->setRules($this->basicRule());
        $this->setRulesByKey('password', ['confirmed']);
        return $this->validate($data);
    }
    public function forVerifyOtp(array $data): bool
    {
        $this->setMessages([
            'otp.exists' => 'Invalid OTP code, or already verified'
        ]);
        $this->setRules([
            'username' => ['required', 'string'],
            'otp' => ['required', 'integer', 'digits:6', Rule::exists(self::TABLE_NAME)->where(function ($query) use ($data) {
                return $query->where('username', $data['username'])->orWhere('email', $data['username']);
            })]
        ]);
        return $this->validate($data);
    }
    public function forForgetPassword(array $data): bool
    {
        $this->setRules([
            'email' => ['required', 'email']
        ]);
        return $this->validate($data);
    }
    public function forResetPassword(array $data): bool
    {
        $this->setRules([
            'email' => ['required', 'email'],
            'password' => ['required', Password::defaults(), 'confirmed'],
            'token' => ['required'],
        ]);
        return $this->validate($data);
    }
    public function forChangePassword(array $data): bool
    {
        $this->setRules([
            'password_old' => ['required', 'current_password:api'],
            'password' => ['required', Password::defaults(), 'confirmed', 'different:password_old'],
        ]);
        return $this->validate($data);
    }
}
