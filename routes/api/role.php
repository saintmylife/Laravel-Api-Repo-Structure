<?php

Route::prefix('roles')->middleware('auth')->group(function() {
    Route::get('/', 'Index\RoleIndexAction')->name('role.index');
    Route::post('/', 'Create\RoleCreateAction')->name('role.create')->middleware('permission:Akses Role');
    Route::get('/{id}', 'Fetch\RoleFetchAction')->name('role.fetch');
    Route::put('/{id}', 'Edit\RoleEditAction')->name('role.edit')->middleware('permission:Akses Role');
    Route::delete('/{id}', 'Delete\RoleDeleteAction')->name('role.delete')->middleware('permission:Akses Role');
});
