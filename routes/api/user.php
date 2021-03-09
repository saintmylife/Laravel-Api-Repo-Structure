<?php

Route::prefix('users')->group(function () {
    Route::post('/', 'Create\UserCreateAction')->name('user.create');
    Route::middleware('jwt.verify')->group(function () {
        Route::get('/', 'Index\UserIndexAction')->name('user.index')->middleware('permission:CRUD EndUser');
        Route::get('/{id}', 'Fetch\UserFetchAction')->name('user.fetch')->middleware('permission:CRUD EndUser');
        Route::put('/{id}', 'Edit\UserEditAction')->name('user.edit');
        Route::delete('/{id}', 'Delete\UserDeleteAction')->name('user.delete')->middleware('permission:CRUD EndUser');
    });
});
