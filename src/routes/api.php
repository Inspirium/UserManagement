<?php

Route::group(['middleware' => ['api', 'auth:api'], 'namespace' => 'Inspirium\UserManagement\Controllers\Api', 'prefix' => 'api/user'], function () {

    Route::get('notifications', 'NotificationController@getNotifications');

});
