<?php

namespace App\Modules\V1\User;

use App\Modules\Base\BaseDto;

class UserDto extends BaseDto
{
    protected $id;
    protected $email;
    protected $username;
    protected $password;
    protected $verified_at;
    protected $otp;
    protected $otp_expired_at;
    protected $name;
    protected $address;
    protected $phone;
    protected $language = 'id';
    protected $role = 'enduser';
    protected $deleted_reason;
}
