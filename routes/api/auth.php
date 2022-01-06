<?php

Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/me', 'Profile\AuthProfileAction')->name('profile');
    Route::post('/login', 'Login\AuthLoginAction')->withoutMiddleware('jwt.verify')->name('login');
    Route::post('/logout', 'Logout\AuthLogoutAction')->name('logout');
});
