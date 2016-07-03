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
    Route::auth();
    Route::get('verify/{code}', 'UserController@verify');
    Route::group(['middleware' => 'social_provider', 'prefix' => 'social', 'as' => 'social::'], function() {
        Route::get('/redirect/{provider}',   ['as' =>  'redirect',   'uses' => 'Auth\SocialController@redirectToProvider']);
        Route::get('/handle/{provider}',     ['as' =>  'handle',     'uses' => 'Auth\SocialController@handleProviderCallback']);
    });

    /* backend func */
    Route::group(['middleware' => 'access:web,0,' . App\User::ROLE_ADMIN, 'prefix' => 'backend', 'as' => 'backend::'], function () {
        Route::get('/', ['uses' => 'Backend\DashboardController@index', 'as' => 'dashboard']);

        Route::group(['prefix' => 'testing-servers', 'as' => 'testing_servers::'], function () {
            Route::get('/', ['uses' => 'Backend\TestingServersController@index', 'as' => 'list']);

            Route::get('add', ['uses' => 'Backend\TestingServersController@showForm', 'as' => 'add']);
            Route::post('add', 'Backend\TestingServersController@edit');

            Route::get('edit/{id}', ['uses' => 'Backend\TestingServersController@showForm', 'as' => 'edit']);
            Route::post('edit/{id}', 'Backend\TestingServersController@edit');

            Route::get('delete/{id}', 'Backend\TestingServersController@delete');
            Route::get('restore/{id}', 'Backend\TestingServersController@restore');
        });

    });

    /*  subdomain func  */
    Route::group(['middleware' => 'admin_redirect', 'domain' => App\Subdomain::currentSubdomainName() . '.' . config('app.domain')], function () {

        Route::get('/', 'HomeController@index');
        Route::get('/teachers', 'TeacherController@index');

        Route::group(['middleware' => 'access:web,1,' . App\User::ROLE_ADMIN, 'as' => 'frontend::'], function () {
            //@todo add to correct route group
            Route::post('/add-teacher', ['as' => 'addTeacher', 'uses' => 'TeacherListAjaxController@addTeacher']);
            Route::group(['middleware' => 'profile_access', 'prefix' => 'user', 'as' => 'user::'], function(){

                Route::post('/add-teacher', 'UserController@addTeacher');
                Route::post('/upgrade','UserController@upgrade');
                Route::get('/edit', ['as' => 'edit', 'uses' => 'UserController@edit']);
                Route::post('/edit', 'UserController@saveEdit');
                Route::get('/{id}',['as' => 'profile', 'uses' => 'UserController@index'])->where('id', '[0-9]+');;

            });
        });
    });

    /*  main domain func  */
    Route::group(['middleware' => 'admin_redirect', 'domain' => config('app.domain')], function () {

        Route::group(['middleware' => 'admin_redirect'], function () {
            Route::get('/', 'MainHomeController@index');
        });
    });
    
});

Route::group(['namespace' => 'TestingSystem', 'prefix' => 'testing-system-api'], function () {
    Route::get('/', function() {
        echo 'Schema will be there';
    });
    Route::group(['prefix' => 'solutions', 'middleware' => 'auth:testing_servers_api'], function () {
        Route::get('{id}',             'SolutionController@show')->where('id', '[0-9]+');
        Route::patch('{id}',           'SolutionController@update')->where('id', '[0-9]+');
        Route::get('{id}/source-code', 'SolutionController@show_source_code')->where('id', '[0-9]+');
        Route::get('latest-new',       'SolutionController@latest_new');
        Route::post('{id}/report',     'SolutionController@store_report')->where('id', '[0-9]+');
    });
    Route::resource('/programming_languages', 'ProgrammingLanguagesController');
});

Route::group(['middleware' => 'api', 'prefix' => 'api'], function () {
    //future
});