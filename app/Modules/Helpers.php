<?php
if (!function_exists('upload_path')) {
    /**
     * Generate 6 Digits Otp and expired
     * @return boolean
     */
    function upload_path($path = '')
    {
        return storage_path('app/public/upload/') . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : $path);
    }
}
if (!function_exists('avatar_path')) {
    /**
     * Generate 6 Digits Otp and expired
     * @return boolean
     */
    function avatar_path()
    {
        return storage_path('app/public/avatars/');
    }
}
if (!function_exists('all_super_admin_role')) {
    /**
     * Return All Super Admin Role
     * @return boolean
     */
    function all_super_admin_role()
    {
        return \Arr::join(\Arr::where(config('app-config.roles'), function ($value, $key) {
            return \Str::contains(
                $value,
                config('app-config.super_admin_role_name')
            );
        }), '|');
    }
}
