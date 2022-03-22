<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Super Admin Role Name
    |--------------------------------------------------------------------------
    |
    | This name is used by the Providers/AuthServiceProvider using 
    | Spattie/permission service to define root-admin role name.
    |
    */

    'super_admin_role_name' => env('SUPER_ADMIN_ROLE_NAME', 'super-admin'),

    /*
    |--------------------------------------------------------------------------
    | Token Name
    |--------------------------------------------------------------------------
    |
    | This name is used by the Laravel/Passport service to generate
    | httpOnly Cookie during the authentication exchange.
    |
    */

    'access_token_name' => env('ACCESS_TOKEN_NAME', 'LARAVEL-AT'),
    'refresh_token_name' => env('REFRESH_TOKEN_NAME', 'LARAVEL-RT'),

    /*
    |--------------------------------------------------------------------------
    | Token Expiry
    |--------------------------------------------------------------------------
    |
    | This value is used by the Laravel/Passport to generate expiry token
    |
    */

    'access_token_exp' => env('ACCESS_TOKEN_EXP', 60),
    'refresh_token_exp' => env('REFRESH_TOKEN_EXP', 60 * 24 * 7),

    /*
    |--------------------------------------------------------------------------
    | Forget Password Url
    |--------------------------------------------------------------------------
    |
    | This name is used by the User Forget Password Link
    | Fallback to app_url
    |
    */

    'reset_password_url' => env('RESET_PASSWORD_URL', 'http://localhost'),

];
