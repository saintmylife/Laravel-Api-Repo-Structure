<?php

Route::prefix('auth')->group(function () {
    // Route::put('/{id}/edit', 'Update\AuthUpdateAction')->name('auth.update');
    Route::get('/me', 'Profile\AuthProfileAction')->middleware('jwt.verify')->name('auth.profile');
    Route::post('/login', 'Login\AuthLoginAction')->name('auth.login');
    Route::post('/logout', 'Logout\AuthLogoutAction')->middleware('jwt.verify')->name('auth.logout');
});
