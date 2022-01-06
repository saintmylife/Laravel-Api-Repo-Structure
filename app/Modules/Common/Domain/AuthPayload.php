<?php

namespace App\Modules\Common\Domain;

use App\Modules\Common\Domain\Payload;

class AuthPayload extends Payload
{
    /** Valid user credentials. */
    const STATUS_AUTHENTICATED = 'AUTHENTICATED';
    /** Invalid user credentials. */
    const STATUS_AUTH_FAILED = 'AUTH_FAILED';
    /** Logout user. */
    const STATUS_AUTH_LOGOUT = 'AUTH_LOGOUT';
}
