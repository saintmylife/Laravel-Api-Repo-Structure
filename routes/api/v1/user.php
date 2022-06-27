<?php

Route::prefix('users')->middleware('auth:api')->name('users.')->group(function () {
    Route::put('/', 'UserEditAction')->name('edit');
    Route::delete('/', 'UserDeleteAction')->middleware('password.confirm')->name('delete');
    Route::middleware('role:' . all_super_admin_role())->group(function () {
        Route::post('/', 'UserCreateAction')->name('create');
        Route::get('/{id}', 'UserFetchAction')->name('fetch');
        Route::get('/', 'UserListAction')->name('list');
        Route::put('/{id}/roles', 'UserChangeRoleAction')->name('edit.role');
        Route::put('/{id}/delete', 'UserSoftDeleteAction')->name('delete.soft');
        Route::put('/{id}/restore', 'UserRestoreAction')->name('delete.restore');
    });
});
