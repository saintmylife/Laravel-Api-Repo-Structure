<?php

Route::prefix('permissions')->middleware('jwt.auth')->group(function () {
    Route::get('/', 'Index\PermissionIndexAction')->name('permission.index')->middleware('permission:personal access');
    // Route::post('/', 'Create\PermissionCreateAction')->name('permission.create')->middleware('permission:Akses User');
    // Route::get('/{id}', 'Fetch\PermissionFetchAction')->name('permission.fetch');
    // Route::put('/{id}', 'Edit\PermissionEditAction')->name('permission.edit');
    // Route::delete('/{id}', 'Delete\PermissionDeleteAction')->name('permission.delete');
});
