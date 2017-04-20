<?php

/*
 * list of user related routes
 *
 *  - /login - POST|GET
 *  - /logout - GET
 *  - /user/{id} - POST|GET|PUT
 */

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Inspirium\UserManagement\Controllers', 'middleware' => 'web'], function() {
    // Authentication Routes...
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::any('logout', 'Auth\LoginController@logout')->name('logout');

    // Registration Routes...
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');

    // Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::group(['middleware' => 'auth'], function() {
        Route::group(['prefix' => 'user'], function() {
            Route::get('/', 'UserController@showUsers');
            Route::get('show/{id}', 'UserController@showUser');
            Route::get('edit/{id?}', 'UserController@showEditForm');
            Route::post('edit/{id?}', 'UserController@submitUser');
            Route::get('delete/{id}', 'UserController@deleteUser');
            Route::get('roles/{id}', 'UserController@showUserRoles');
            Route::post('roles/{id}', 'UserController@updateUserRoles');

            Route::group(['prefix' => 'role'], function() {
                Route::get('/', 'RoleController@showRoles');
                Route::get('/edit/{id?}', 'RoleController@showRole');
                Route::get('/delete/{id}', 'RoleController@deleteRole');
                Route::post('/edit/{id?}', 'RoleController@submitRole');
            });
        });

    });
});
