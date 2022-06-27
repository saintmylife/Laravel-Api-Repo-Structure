<?php

use Illuminate\Support\Arr;

return [
    /*
    |-------------------------------------------
    | Current API Version
    |-------------------------------------------
    */
    'version' => 1,
    /*
    |--------------------------------------------------------------------------
    | Role and Permission
    |--------------------------------------------------------------------------
    |
    | This name is used by the Providers/AuthServiceProvider using 
    | Spattie/permission service to define root-admin role name and
    | Permission
    |
    */

    'super_admin_role_name' => env('SUPER_ADMIN_ROLE_NAME', 'super-admin'),
    'roles' => [
        env('SUPER_ADMIN_ROLE_NAME', 'super-admin'),
        'co-' .  env('SUPER_ADMIN_ROLE_NAME', 'super-admin'),
        'organizer',
        'enduser',
        'customer'
    ],
    'permissions' => [
        'events-create',
        'events-read',
        'events-update',
        'events-delete',
        'guests-create',
        'guests-read',
        'guests-update',
        'guests-delete',
        'guests-import',
        'guests-export',
    ],
    /**
     * Protected Route With Password Confirmation
     */
    'password_confirmation' => env('PASSWORD_CONFIRMATION', 'X-PASSWORD-CONFIRMATION'),

    /*
    |--------------------------------------------------------------------------
    | Token Name
    |--------------------------------------------------------------------------
    |
    | This name is used by the Laravel/Passport service to generate
    | httpOnly Cookie during the authentication exchange.
    |
    */
    'token' => [
        'access' => [
            'name' => env('ACCESS_TOKEN_NAME', 'LARAVEL-AT'),
            'exp' => env('ACCESS_TOKEN_EXP', 60),
        ],
        'refresh' => [
            'name' => env('REFRESH_TOKEN_NAME', 'LARAVEL-RT'),
            'exp' => env('REFRESH_TOKEN_EXP', 60 * 24 * 7)
        ]
    ],
    'url' => [
        /*
        |--------------------------------------------------------------------------
        | Forget Password Url
        |--------------------------------------------------------------------------
        |
        | This name is used by the User Forget Password Link
        | Fallback to app_url
        |
        */
        'reset_password' => env('RESET_PASSWORD_URL', 'http://localhost:8013/reset-password'),
    ],
    'passport' => [
        'client_name' => 'Redd One First Party App',
        'client_id' => env('PASSPORT_FIRST_PARTY_GRANT_PASSWORD_ID', 1),
        'secret' => env('PASSPORT_FIRST_PARTY_GRANT_PASSWORD_SECRET', null)
    ]
];
