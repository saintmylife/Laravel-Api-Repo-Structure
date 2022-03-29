<?php

namespace App\Modules\Common\Domain;

use App\Modules\Common\Domain\Payload;

class AuthPayload extends Payload
{
    /** Valid user credentials. */
    const STATUS_AUTHENTICATED = 'AUTHENTICATED';
    /** Invalid data request. */
    const STATUS_AUTH_NOT_VALID = 'AUTH_NOT_VALID';
    /** Invalid user credentials. */
    const STATUS_AUTH_FAILED = 'AUTH_FAILED';
    /** Authorization token not found */
    const STATUS_AUTH_TOKEN_NOT_FOUND = 'AUTH_TOKEN_NOT_FOUND';
    /** Invalid or expired token */
    const STATUS_AUTH_TOKEN_INVALID = 'AUTH_TOKEN_INVALID';
    /** Logout user. */
    const STATUS_AUTH_LOGOUT = 'AUTH_LOGOUT';
    /** Failed to Verify User */
    const STATUS_AUTH_VERIFY_FAILED = 'AUTH_VERIFY_FAILED';
    /** Success Verify User */
    const STATUS_AUTH_VERIFY_SUCCESS = 'AUTH_VERIFY_SUCCESS';
    /** Send Email Notification */
    const STATUS_AUTH_SEND_EMAIL = 'AUTH_SEND_EMAIL';
    /** Old password is not same */
    const STATUS_AUTH_CHANGE_PASSWORD_FAILED = 'AUTH_CHANGE_PASSWORD_FAILED';
    /** Success change password */
    const STATUS_AUTH_CHANGE_PASSWORD_SUCCESS = 'AUTH_CHANGE_PASSWORD_SUCCESS';
    /** Reset password failed */
    const STATUS_AUTH_RESET_PASSWORD_FAILED = 'AUTH_RESET_PASSWORD_FAILED';
    /** Reset password success */
    const STATUS_AUTH_RESET_PASSWORD_SUCCESS = 'AUTH_RESET_PASSWORD_SUCCESS';
    /** Confirm password is same */
    const STATUS_AUTH_CONFIRM_PASSWORD = 'AUTH_CONFIRM_PASSWORD';
    /** Clear Cookies */
    const STATUS_AUTH_CLEAR_COOKIES = 'AUTH_CLEAR_COOKIES';
}
