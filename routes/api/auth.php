<?php

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/login', 'AuthLoginAction')->withoutMiddleware('auth:api')->name('login');
    Route::get('/me', 'AuthProfileAction')->name('profile');
    Route::post('/logout', 'AuthLogoutAction')->name('logout');
});
