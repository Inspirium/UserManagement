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
        Route::get('users', 'UserController@showUsers');
        Route::get('user/show/{id}', 'UserController@showUser');
        Route::get('user/edit/{id?}', 'UserController@showEditForm');
        Route::post('user/edit/{id?}', 'UserController@submitUser');
        Route::get('user/delete/{id}', 'UserController@deleteUser');
    });
});
