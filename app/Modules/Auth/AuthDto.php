<?php

namespace App\Modules\Auth;

use App\Modules\Base\BaseDto;

/**
 * Auth DTO
 */
class AuthDto extends BaseDto
{
    protected $name;
    protected $email;
    protected $password;
}
