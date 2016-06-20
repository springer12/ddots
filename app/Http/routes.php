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


Route::group(['namespace' => 'TestingSystem', 'middleware' => 'testing_system', 'prefix' => 'testing_system_api'], function () {
    
});

Route::group(['middleware' => 'web'], function () {


});

Route::group(['middleware' => 'api'], function () {

});

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');
