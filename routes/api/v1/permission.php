<?php

Route::prefix('permissions')->middleware('auth:api', 'role:' . config('app-config.super_admin_role_name'))->name('permissions.')->group(function () {
    Route::get('/', 'PermissionListAction')->name('list');
    Route::get('/{id}', 'PermissionFetchAction')->name('fetch');
    Route::post('/', 'PermissionCreateAction')->name('create');
    Route::put('/{id}', 'PermissionEditAction')->name('edit');
    Route::delete('/{id}', 'PermissionDeleteAction')->name('delete');
});
