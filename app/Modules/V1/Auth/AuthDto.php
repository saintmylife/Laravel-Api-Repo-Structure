<?php

namespace App\Modules\V1\Auth;

use App\Modules\V1\User\UserDto;
use Faker\Generator;

class AuthDto extends UserDto
{
    protected $client;
    protected $password_old;
    protected $password_confirmation;
    protected $token;
    protected $client_id = 1;


    public function encryptPassword()
    {
        if (!empty($this->password)) {
            $this->__set('password', bcrypt($this->password));
        };
        if (!empty($this->password_confirmation)) {
            unset($this->password_confirmation);
        };
        if (!empty($this->password_old)) {
            unset($this->password_old);
        };
        return $this;
    }

    public function generateOtp()
    {
        $this->__set('otp', (resolve(Generator::class))->randomNumber(6, true));
        $this->__set('otp_expired_at', now()->addMinutes(2));
        return $this;
    }
}
