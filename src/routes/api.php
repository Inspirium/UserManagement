<?php

/*
 * list of user related routes
 *
 *  - /login - POST|GET
 *  - /logout - GET
 *  - /user/{id} - POST|GET|PUT
 */


use Illuminate\Http\Request;


Route::group(['middleware' => ['api']], function (Request $request) {

    Route::any('login', function() {});
    Route::any('logout', function() {});

    Route::group(['middleware' =>'auth:api'], function() {
        Route::get('user/{id?}', function ($id) {})->where(['id' => '[0-9]+']); // get create user form or user edit form
        Route::post('user', function() {}); // post create user form
        Route::put('user/{id}', function($id) {}); //update user form
    });


});
