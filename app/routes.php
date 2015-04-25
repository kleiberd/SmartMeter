<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::group(array('before' => 'auth'), function() {

    Route::get('admin',                     'AdminController@index');

    Route::get('admin/sensor/add',          'SensorController@addGet');
    Route::post('admin/sensor/add',         'SensorController@addPost');

    Route::get('admin/sensor/get/{id}',     'SensorController@sensorGet');
    Route::post('admin/sensor/get/{id}',    'SensorController@sensorPost');

    Route::get('admin/databases',           'DatabaseController@databaseGet');

});


Route::group(array('before' => 'guest'), function() {

    Route::get('login',                     'AdminController@loginGet');
    Route::post('login',                    'AdminController@loginPost');

    Route::get('api/sensors',               'ApiController@sensorsGet');
    Route::get('api/sensors/{id}',          'ApiController@sensorGetById');
    Route::get('api/sensors/daily/{id}',    'ApiController@sensorDailyGet');
    Route::post('api/upload',               'ApiController@uploadPost');

    Route::get('sensor/{id}',               'SensorController@sensorGuestGet');

});

Route::get('/',                             'HomeController@index');
Route::get('admin/logout',                  'AdminController@logoutGet');