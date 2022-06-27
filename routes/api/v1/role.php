<?php

Route::prefix('roles')->middleware('auth:api', 'role:' . config('app-config.super_admin_role_name'))->name('roles.')->group(function () {
    Route::get('/', 'RoleListAction')->name('list');
    Route::get('/{id}', 'RoleFetchAction')->name('fetch');
    Route::post('/', 'RoleCreateAction')->name('create');
    Route::put('/{id}', 'RoleEditAction')->name('edit');
    Route::delete('/{id}', 'RoleDeleteAction')->name('delete');
});
