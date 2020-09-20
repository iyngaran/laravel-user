<?php
Route::post('/login', 'AuthController@login')->name('login');
Route::get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');
//Route::post('/reset-password', 'ResetPasswordController')->name('reset.password');

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', 'AuthController@me')->name('users.me');
    Route::resources(
        [
            'user-permissions' => 'UserPermissionController',
            'user-roles' => 'UserRoleController',
            'users' => 'UserController',
        ]
    );
});
