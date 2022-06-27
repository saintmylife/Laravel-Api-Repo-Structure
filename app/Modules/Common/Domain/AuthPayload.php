<?php

namespace App\Modules\Common\Domain;

interface AuthPayload
{
    /** Logged In Successfully */
    const STATUS_AUTH_LOGGED_IN = 'AUTH_LOGGED_IN';
    /** Logged Out Successfully */
    const STATUS_AUTH_LOGGED_OUT = 'AUTH_LOGGED_OUT';
    /** Credentials Found */
    const STATUS_AUTH_FOUND = 'AUTH_FOUND';
    /** Auth Expired */
    const STATUS_AUTH_EXPIRED = 'AUTH_EXPIRED';
    /** Auth Transient Token Success */
    const STATUS_AUTH_TRANSIENT = 'AUTH_TRANSIENT';
    /** Auth Not Valid */
    const STATUS_AUTH_NOT_VALID = 'AUTH_NOT_VALID';
    /** User Not Verified */
    const STATUS_AUTH_NOT_VERIFIED = 'AUTH_NOT_VERIFIED';
    /** Auth Verify OTP Already */
    const STATUS_AUTH_VERIFY_OTP_ALREADY = 'AUTH_VERIFY_OTP_ALREADY';
    /** Auth Verify OTP Expired */
    const STATUS_AUTH_VERIFY_OTP_EXPIRED = 'AUTH_VERIFY_OTP_EXPIRED';
    /** Auth Verify OTP Success */
    const STATUS_AUTH_VERIFY_OTP_SUCCESS = 'AUTH_VERIFY_OTP_SUCCESS';
    /** Auth Send Email */
    const STATUS_AUTH_SEND_EMAIL = 'AUTH_SEND_EMAIL';
    /** Reset Password Failed */
    const STATUS_AUTH_RESET_PASSWORD_FAILED = 'AUTH_RESET_PASSWORD_FAILED';
    /** Reset Password Success */
    const STATUS_AUTH_RESET_PASSWORD_SUCCESS = 'AUTH_RESET_PASSWORD_SUCCESS';
    /** Change Password Success */
    const STATUS_AUTH_CHANGE_PASSWORD_SUCCESS = 'AUTH_CHANGE_PASSWORD_SUCCESS';
    /** Auth Password Confirm */
    const STATUS_AUTH_PASSWORD_CONFIRM = 'AUTH_PASSWORD_CONFIRM';
    /** Unautorized User */
    const STATUS_UNAUTHORIZED = 'UNAUTHORIZED';
    /** Guest User */
    const STATUS_AUTH_GUEST_USER = 'AUTH_GUEST_USER';
    /** Forbidden access */
    const STATUS_FORBIDDEN = 'FORBIDDEN';
    /** Determine if resource isnt owner */
    const STATUS_NOT_OWNER = 'NOT_OWNER';
    /** Determine if resource is protected */
    const STATUS_PROTECTED_RESOURCE = 'PROTECTED_RESOURCE';
}
