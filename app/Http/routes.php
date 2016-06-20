<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'web'], function () {
    Route::get('/home', 'HomeController@index');
    Route::get('/', 'HomeController@index');

    Route::auth();

    Route::group(['middleware' => 'access:web,1,' . App\User::ROLE_ADMIN, 'prefix' => 'frontend', 'as' => 'frontend::'], function () {

    });
    Route::group(['middleware' => 'access:web,0,' . App\User::ROLE_ADMIN, 'prefix' => 'backend', 'as' => 'backend::'], function () {

    });

});

Route::group(['namespace' => 'TestingSystem', 'middleware' => 'testing_system', 'prefix' => 'testing_system_api'], function () {

});

Route::group(['middleware' => 'api', 'prefix' => 'api'], function () {
    //future
});