<?php

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/logout', 'AuthLogoutAction')->name('logout');
    Route::get('/me', 'AuthMeAction')->name('me');
    Route::put('/change-password', 'AuthChangePasswordAction')->name('password.change');
});
