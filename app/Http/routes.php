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

    // Authentication Routes...
    $this->post('login', 'Auth\AuthController@login');
    $this->get('logout', 'Auth\AuthController@logout');

    // Registration Routes...
    $this->get('register', 'Auth\AuthController@showRegistrationForm');
    $this->post('register', 'Auth\AuthController@register');

    // Password Reset Routes...
    $this->get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    $this->post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    $this->post('password/reset', 'Auth\PasswordController@reset');

    Route::get('verify/{code}', 'UserController@verify');
    Route::group(['middleware' => 'social_provider', 'prefix' => 'social', 'as' => 'social::'], function () {
        Route::get('/redirect/{provider}', ['as' => 'redirect', 'uses' => 'Auth\SocialController@redirectToProvider']);
        Route::get('/handle/{provider}', ['as' => 'handle', 'uses' => 'Auth\SocialController@handleProviderCallback']);
    });

    Route::any('ts', function() {
        echo 123;
    });
    
    /* backend func */
    Route::group([
        'middleware' => 'access:web,0,' . App\User::ROLE_ADMIN,
        'prefix' => 'backend',
        'as' => 'backend::',
    ], function () {
        Route::group(['middleware' => 'ajax', 'as' => 'ajax::'], function () {
            Route::get('/search-students', ['as' => 'searchStudents', 'uses' => 'Ajax\UserController@searchStudents']);
            Route::get('/get-students', ['as' => 'getStudents', 'uses' => 'Ajax\UserController@getStudents']);
            Route::get('/search-teachers', ['as' => 'searchTeachers', 'uses' => 'Ajax\UserController@searchTeachers']);
        });
        Route::get('/', ['uses' => 'Backend\DashboardController@index', 'as' => 'dashboard']);

        Route::get('/tester', ['uses' => 'Backend\TesterController@index', 'as' => 'tester']);
        Route::post('/tester', ['uses' => 'Backend\TesterController@test']);

        Route::group(['prefix' => 'testing-servers', 'as' => 'testing_servers::'], function () {
            Route::get('/', ['uses' => 'Backend\TestingServersController@index', 'as' => 'list']);

            Route::get('add', ['uses' => 'Backend\TestingServersController@showForm', 'as' => 'add']);
            Route::post('add', 'Backend\TestingServersController@edit');

            Route::get('edit/{id}', ['uses' => 'Backend\TestingServersController@showForm', 'as' => 'edit']);
            Route::post('edit/{id}', 'Backend\TestingServersController@edit');

            Route::get('delete/{id}', 'Backend\TestingServersController@delete');
            Route::get('restore/{id}', 'Backend\TestingServersController@restore');
        });

        Route::group(['prefix' => 'news', 'as' => 'news::'], function () {
            Route::get('/', ['uses' => 'Backend\NewsController@index', 'as' => 'list']);

            Route::get('add', ['uses' => 'Backend\NewsController@showForm', 'as' => 'add']);
            Route::post('add', 'Backend\NewsController@edit');

            Route::get('edit/{id}', ['uses' => 'Backend\NewsController@showForm', 'as' => 'edit']);
            Route::post('edit/{id}', 'Backend\NewsController@edit');

            Route::get('delete/{id}', 'Backend\NewsController@delete');
            Route::get('restore/{id}', 'Backend\NewsController@restore');
        });

        Route::group(['prefix' => 'messaging', 'as' => 'messages::'], function () {
            Route::get('/', ['uses' => 'Backend\MessageController@index', 'as' => 'list']);

            Route::get('/{id}', ['uses' => 'Backend\MessageController@dialog', 'as' => 'dialog'])->where('id', '[0-9]+');
            Route::post('/{id}', 'Backend\MessageController@send')->where('id', '[0-9]+');
        });

        Route::group(['prefix' => 'programming-languages', 'as' => 'programming_languages::'], function () {
            Route::get('/', ['uses' => 'Backend\ProgrammingLanguageController@index', 'as' => 'list']);

            Route::get('add', ['uses' => 'Backend\ProgrammingLanguageController@showForm', 'as' => 'add']);
            Route::post('add', 'Backend\ProgrammingLanguageController@edit');

            Route::get('edit/{id}', ['uses' => 'Backend\ProgrammingLanguageController@showForm', 'as' => 'edit']);
            Route::post('edit/{id}', 'Backend\ProgrammingLanguageController@edit');

            Route::get('delete/{id}', 'Backend\ProgrammingLanguageController@delete');
            Route::get('restore/{id}', 'Backend\ProgrammingLanguageController@restore');
        });

        Route::group(['prefix' => 'subdomains', 'as' => 'subdomains::'], function () {
            Route::get('/', ['uses' => 'Backend\SubdomainController@index', 'as' => 'list']);

            Route::get('add', ['uses' => 'Backend\SubdomainController@showForm', 'as' => 'add']);
            Route::post('add', 'Backend\SubdomainController@edit');

            Route::get('edit/{id}', ['uses' => 'Backend\SubdomainController@showForm', 'as' => 'edit']);
            Route::post('edit/{id}', 'Backend\SubdomainController@edit');

            Route::get('delete/{id}', 'Backend\SubdomainController@delete');
            Route::get('restore/{id}', 'Backend\SubdomainController@restore');
        });

        Route::group(['prefix' => 'contests', 'as' => 'contests::'], function () {
            Route::get('/', ['uses' => 'Backend\ContestController@index', 'as' => 'list']);
            Route::get('/show/{id}', ['uses' => 'Backend\ContestController@show', 'as' => 'show'])
                ->where('id', '[0-9]+');
            Route::get('/hide/{id}', ['uses' => 'Backend\ContestController@hide', 'as' => 'hide'])
                ->where('id', '[0-9]+');
            Route::get('add', ['uses' => 'Backend\ContestController@showForm', 'as' => 'add']);
            Route::post('add', 'Backend\ContestController@edit');
            Route::get('edit/{id}', ['uses' => 'Backend\ContestController@showForm', 'as' => 'edit'])
                ->where('id', '[0-9]+');
            Route::post('edit/{id}', ['uses' => 'Backend\ContestController@edit'])->where('id', '[0-9]+');
        });

        Route::group(['prefix' => 'sponsors', 'as' => 'sponsors::'], function () {
            Route::get('/', ['uses' => 'Backend\SponsorController@index', 'as' => 'list']);

            Route::get('add', ['uses' => 'Backend\SponsorController@showForm', 'as' => 'add']);
            Route::post('add', 'Backend\SponsorController@edit');

            Route::get('edit/{id}', ['uses' => 'Backend\SponsorController@showForm', 'as' => 'edit']);
            Route::post('edit/{id}', 'Backend\SponsorController@edit');

            Route::get('delete/{id}', 'Backend\SponsorController@delete');
            Route::get('restore/{id}', 'Backend\SponsorController@restore');
        });

        Route::group(['prefix' => 'users', 'as' => 'users::'], function () {
            Route::get('/', ['uses' => 'Backend\UserController@index', 'as' => 'list']);

            Route::get('add', ['uses' => 'Backend\UserController@showForm', 'as' => 'add']);
            Route::post('add', 'Backend\UserController@edit');

            Route::get('edit/{id}', ['uses' => 'Backend\UserController@showForm', 'as' => 'edit']);
            Route::post('edit/{id}', 'Backend\UserController@edit');

            Route::get('delete/{id}', 'Backend\UserController@delete');
            Route::get('restore/{id}', 'Backend\UserController@restore');
        });

        Route::group(['prefix' => 'groups', 'as' => 'groups::'], function () {
            Route::get('/', ['uses' => 'Backend\GroupController@index', 'as' => 'list']);

            Route::get('add', ['uses' => 'Backend\GroupController@showForm', 'as' => 'add']);
            Route::post('add', 'Backend\GroupController@edit');

            Route::get('edit/{id}', ['uses' => 'Backend\GroupController@showForm', 'as' => 'edit']);
            Route::post('edit/{id}', 'Backend\GroupController@edit');

            Route::get('delete/{id}', 'Backend\GroupController@delete');
            Route::get('restore/{id}', 'Backend\GroupController@restore');
        });

        Route::group(['prefix' => 'volumes', 'as' => 'volumes::'], function () {
            Route::get('/', ['uses' => 'Backend\VolumeController@index', 'as' => 'list']);

            Route::get('add', ['uses' => 'Backend\VolumeController@showForm', 'as' => 'add']);
            Route::post('add', 'Backend\VolumeController@edit');

            Route::get('edit/{id}', ['uses' => 'Backend\VolumeController@showForm', 'as' => 'edit']);
            Route::post('edit/{id}', 'Backend\VolumeController@edit');

            Route::get('delete/{id}', 'Backend\VolumeController@delete');
            Route::get('restore/{id}', 'Backend\VolumeController@restore');
        });

        Route::group(['prefix' => 'problems', 'as' => 'problems::'], function () {
            Route::get('/', ['uses' => 'Backend\ProblemController@index', 'as' => 'list']);

            Route::get('add', ['uses' => 'Backend\ProblemController@showForm', 'as' => 'add']);
            Route::post('add', 'Backend\ProblemController@edit');

            Route::get('edit/{id}', ['uses' => 'Backend\ProblemController@showForm', 'as' => 'edit']);
            Route::post('edit/{id}', 'Backend\ProblemController@edit');

            Route::get('delete/{id}', 'Backend\ProblemController@delete');
            Route::get('restore/{id}', 'Backend\ProblemController@restore');
        });

    });

    /*  subdomain func  */
    Route::group([
        'middleware' => 'admin_redirect',
        'domain' => App\Subdomain::currentSubdomainName() . '.' . config('app.domain'),
    ], function () {

        Route::get('/', 'HomeController@index');
        Route::get('/teachers', 'TeacherController@index');
        Route::get('/sponsors', 'SponsorController@index');
        Route::get('/news', 'NewsController@index');
        Route::get('/news/{id}', 'NewsController@domainSingle')->where('id', '[0-9]+');

        Route::group(['middleware' => 'access:web,0,' . App\User::ROLE_TEACHER, 'as' => 'teacherOnly::'], function () {

            Route::post('solution-message/{id}', ['uses' => 'SolutionMessageController@message', 'as' => 'message']);
            Route::group(['prefix' => 'solutions', 'as' => 'solutions::'], function () {
                Route::get('{id}/annul', ['uses' => 'SolutionController@annul', 'as' => 'annul']);
                Route::get('{id}/approve', ['uses' => 'SolutionController@approve', 'as' => 'approve']);
                Route::get('{id}/decline', ['uses' => 'SolutionController@decline', 'as' => 'decline']);
            });

            Route::group(['prefix' => 'contests', 'as' => 'contests::'], function () {
                Route::get('/hide/{id}', ['uses' => 'ContestController@hide', 'as' => 'hide'])->where('id', '[0-9]+');
                Route::get('/show/{id}', ['uses' => 'ContestController@show', 'as' => 'show'])->where('id', '[0-9]+');
                Route::get('add', ['uses' => 'ContestController@showForm', 'as' => 'add']);
                Route::post('add', 'ContestController@edit');

                Route::get('edit/{id}', [
                    'middleware' => 'contest_edit_access',
                    'uses' => 'ContestController@showForm',
                    'as' => 'edit',
                ])->where('id', '[0-9]+');
                Route::post('edit/{id}', ['middleware' => 'contest_edit_access', 'uses' => 'ContestController@edit'])
                    ->where('id', '[0-9]+');
            });

            Route::group(['prefix' => 'groups', 'as' => 'groups::'], function () {
                Route::get('/', ['uses' => 'GroupController@index', 'as' => 'list']);

                Route::get('add', ['uses' => 'GroupController@showForm', 'as' => 'add']);
                Route::post('add', 'GroupController@edit');

                Route::get('edit/{id}', ['uses' => 'GroupController@showForm', 'as' => 'edit']);
                Route::post('edit/{id}', 'GroupController@edit')->where('id', '[0-9]+');

                Route::get('delete/{id}', 'GroupController@delete')->where('id', '[0-9]+');
                Route::get('restore/{id}', 'GroupController@restore')->where('id', '[0-9]+');
            });

            Route::group(['prefix' => 'students', 'as' => 'students::'], function () {
                Route::get('/', ['uses' => 'StudentController@index', 'as' => 'list']);
            });
        });

        Route::group(['middleware' => 'access:web,1,' . App\User::ROLE_ADMIN, 'as' => 'frontend::'], function () {
            Route::group(['middleware' => 'ajax', 'as' => 'ajax::'], function () {
                Route::get('/add-teacher/{id}', ['as' => 'addTeacher', 'uses' => 'Ajax\UserController@addTeacher'])
                    ->where('id', '[0-9]+');
                Route::get('/confirm-student/{id}', ['as' => 'confirmStudent', 'uses' => 'Ajax\UserController@confirm'])
                    ->where('id', '[0-9]+');
                Route::get('/decline-student/{id}', ['as' => 'declineStudent', 'uses' => 'Ajax\UserController@decline'])
                    ->where('id', '[0-9]+');
                Route::get('/add-student-to-group', [
                    'as' => 'addStudentToGroup',
                    'uses' => 'Ajax\UserController@addToGroup',
                ]);
            });

            Route::group(['prefix' => 'messaging', 'as' => 'messages::'], function () {
                Route::get('/', ['uses' => 'MessageController@index', 'as' => 'list']);

                Route::get('/new', ['uses' => 'MessageController@newDialog', 'as' => 'new']);
                Route::post('/new', 'MessageController@send');

                Route::get('/{id}', ['uses' => 'MessageController@dialog', 'as' => 'dialog'])->where('id', '[0-9]+');
                Route::post('/{id}', 'MessageController@send')->where('id', '[0-9]+');
            });

            Route::group(['prefix' => 'contests', 'as' => 'contests::'], function () {
                Route::get('/', ['uses' => 'ContestController@index', 'as' => 'list']);
                Route::get('/{id}', ['uses' => 'ContestController@single', 'as' => 'single'])->where('id', '[0-9]+');
                Route::get('/{contest_id}/{problem_id}/', [
                    'uses' => 'ProblemController@contestProblem',
                    'as' => 'problem',
                ])->where('contest_id', '[0-9]+')->where('problem_id', '[0-9]+');
                Route::post('/{contest_id}/{problem_id}/', ['uses' => 'SolutionController@submit', 'as' => 'contest_problem'])
                    ->where('contest_id', '[0-9]+')
                    ->where('problem_id', '[0-9]+');
                Route::get('/{id}/standings/', [
                    'middleware' => 'contest_standings_access',
                    'uses' => 'ContestController@standings',
                    'as' => 'standings',
                ])->where('id', '[0-9]+');
                Route::get('/solutions/{id}/', ['uses' => 'SolutionController@contestSolution', 'as' => 'solution'])
                    ->where('id', '[0-9]+');
                Route::get('/{id}/solutions/', ['uses' => 'SolutionController@contestSolutions', 'as' => 'solutions'])
                    ->where('id', '[0-9]+');
            });
        });
        Route::group(['middleware' => 'profile_access', 'prefix' => 'user', 'as' => 'frontend::user::'], function () {
            Route::post('/add-teacher', 'UserController@addTeacher');
            Route::post('/upgrade', 'UserController@upgrade');
            Route::get('/edit', ['as' => 'edit', 'uses' => 'UserController@edit']);
            Route::post('/edit', ['as' => 'edit', 'uses' => 'UserController@saveEdit']);
            Route::get('/{id}', ['as' => 'profile', 'uses' => 'UserController@index'])->where('id', '[0-9]+');
        });
        Route::group(['middleware' => 'access:web,0,' . App\User::ROLE_TEACHER . ',' . App\User::ROLE_ADMIN, 'as' => 'privileged::'], function () {
            Route::group(['middleware' => 'ajax', 'as' => 'ajax::'], function () {
                Route::get('/search-problems', ['as' => 'searchProblems', 'uses' => 'Ajax\ProblemController@search']);
                Route::get('/search-volumes', ['as' => 'searchVolumes', 'uses' => 'Ajax\VolumeController@search']);
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
    Route::get('/', function () {
        echo 'Schema will be there';
    });
    Route::post('auth/', ['middleware' => 'auth:testing_servers_auth', 'uses' => 'TestingServerController@getToken']);

    Route::group(['prefix' => 'problems', 'middleware' => 'auth:testing_servers_api'], function () {
        Route::get('{id}/tests-archive.tar.gz', 'ProblemController@getArchive');
    });
    Route::group(['prefix' => 'solutions', 'middleware' => 'auth:testing_servers_api'], function () {
        Route::get('{id}', 'SolutionController@show')->where('id', '[0-9]+');
        Route::patch('{id}', 'SolutionController@update')->where('id', '[0-9]+');
        Route::get('{id}/source-code', 'SolutionController@show_source_code')->where('id', '[0-9]+');
        Route::get('latest-new', 'SolutionController@latest_new');
        Route::post('{id}/report', 'SolutionController@store_report')->where('id', '[0-9]+');
    });
    Route::get('/programming-languages', 'ProgrammingLanguagesController@index');
});

Route::get('/teachers', 'TeacherController@main');
Route::get('/sponsors', 'SponsorController@main');
Route::get('/news', 'NewsController@main');
Route::get('/news/{id}', 'NewsController@mainSingle')->where('id', '[0-9]+');

Route::group(['middleware' => 'api', 'prefix' => 'api'], function () {
    //future
});

Route::get('tracker', function () {
    return view('tracker');
});

Route::get('report', function () {
    return view('report');
});

Route::post('tracker', function (Illuminate\Http\Request $request) {
    DB::insert('
INSERT INTO work_time_reports (`desc`,`minutes`,`when`, `who`)
VALUES (?,?,?,?);
', [
        $request->get('desc'),
        $request->get('minutes'),
        $request->get('when'),
        $request->get('who'),
    ]);

    return redirect()->to('tracker');
});
