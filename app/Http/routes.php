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

    Route::get('ts/bot/', function() {

error_reporting(1);
ini_set('display_errors', 1);

/* Bot's configuration section */

define('DIR_FS_DOTSBOT', DIR_FS_DOTSLOG);
define('BOT_LOGFILE', DIR_FS_DOTSBOT . 'botlog.log');
define('BOT_IMPORTLOGFILE', DIR_FS_DOTSBOT . 'import.log');
define('BOT_MAXLOG', 512*1024); // 512 = 2 clents * 2880 queryes * 100 bytes ~ 1 day
$bot_log = 0;
$import_log = 0;

define('RA_MIN_SIZE', 4);
define('RA_MAX_SIZE', 64*1024);

/* Bot's friends */
$friends = array();
$friends[] = 'vbox-one:xobo1ven';
$friends[] = 'vbox-two:woto2bxw';

//$friends[] = 'vbox-gcj:jgco3vbx';

//$friends[] = 'vbox-m1:moxa1vb';
//$friends[] = 'vbox-m1:moxa1vb';
//$friends[] = 'na-home:oawiny';
//$friends[] = 'laptop:toplap';
//$friends[] = 'meta1:tema1';
//$friends[] = 'meta2:tema2';
//$friends[] = 'flop1:xolop';
//$friends[] = 'flop2:xolop';
//$friends[] = 'dbbest:dbtest';
//$friends[] = 'dzhul:gakov';
//$friends[] = 'ag45server:school42b';
//$friends[] = 'galuza:asus';
//$friends[] = 'bond:bond007';
//$friends[] = 'batik:gluk';
//$friends[] = 'test:test';

/* End of configuration section *

if (is_int(strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')))
{
    ob_start("ob_gzhandler");
    $gzip_enabled = true;
}

/* Bot's routine */
function can() {
    return true;
}
function gzip_enabled() {
    global $gzip_enabled;
    return isset($gzip_enabled) ? $gzip_enabled : false;
}

function blog($msg) {
    global $bot_log;
    $bakname = BOT_LOGFILE.".".date("md-Hi");
    if ((@filesize(BOT_LOGFILE) > BOT_MAXLOG) &&
        (@rename(BOT_LOGFILE, BOT_LOGFILE.".".date("md-Hi")))) {
        $bot_log = @fopen(BOT_LOGFILE, 'wt');
    }
    if (!$bot_log) {
        $perms = @fileperms(BOT_LOGFILE);
        if ($perms && (($perms & 0777) != 0666))
            @chmod(BOT_LOGFILE, 0666);
        $bot_log = @fopen(BOT_LOGFILE, 'at');
    }
    if ($bot_log) {
        $auth_user = !empty($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : "-";
        $remote_addr = !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : "unknown";
        fwrite($bot_log, date('M d H:i:s')." $auth_user $remote_addr $msg\n");
    }
}

function import_blog($msg) {
    global $import_log;
    $bakname = BOT_IMPORTLOGFILE.".".date("md-Hi");
    if ((@filesize(BOT_IMPORTLOGFILE) > BOT_MAXLOG) &&
        (@rename(BOT_IMPORTLOGFILE, BOT_IMPORTLOGFILE.".".date("md-Hi")))) {
        $import_log = @fopen(BOT_IMPORTLOGFILE, 'wt');
    }
    if (!$import_log) {
        $perms = @fileperms(BOT_IMPORTLOGFILE);
        if ($perms && (($perms & 0777) != 0666))
            @chmod(BOT_IMPORTLOGFILE, 0666);
        $import_log = @fopen(BOT_IMPORTLOGFILE, 'at');
    }
    if ($import_log) {
        fwrite($import_log, date('M d H:i:s')." $msg\n");
    }
}

function error($msg) {
    blog($msg);
    die($msg."\n");
}

function is_msie() {
    $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
    $is_msie = is_int(strpos($user_agent, 'MSIE'));
    return $is_msie;
}

function get_raw_post_data() {
    global $HTTP_RAW_POST_DATA;
    if (!isset($HTTP_RAW_POST_DATA)) {
        $HTTP_RAW_POST_DATA = file_get_contents("php://input");
    }
    return $HTTP_RAW_POST_DATA;
}
function db_query() {
    return true;
}
function db_affected_rows() {
    return true;
}

function bot_checkout_solution($id, $mode = -3) {
    $id = (int)$id;
    $mode = (int)$mode;
    $time = time();
    db_query("UPDATE {solutions} SET test_result='$mode', checked_time='$time' ".
        "WHERE solution_id='$id' AND test_result<0 LIMIT 1");
    $rows = db_affected_rows();
    blog("Checkout $id set $mode affected $rows");
}

function bot_rollback_solution($id) {
    return bot_checkout_solution($id, -1);
}

function db_query_object() {
    return true;
}

function solution_fullname() {

    return true;
}

function bot_give_sname() {
    $where = "";

    if (isset($_GET['cid'])) {
        $where .= " AND contest_id=".(int)$_GET['cid'];
    }
    if (strpos($_SERVER['PHP_AUTH_USER'],'java'))
        $where .= " AND lang_id=6";
    else
        $where .= " AND lang_id<>6";

    $so = db_query_object("SELECT solution_id,problem_id,user_id,lang_id,check_type " .
        "FROM {solutions} WHERE test_result='-1' $where ORDER BY posted_time LIMIT 1");

    $filename = '-1';

    if (isset($so) && isset($so->solution_id) && $so->solution_id) {
        $fullname = solution_fullname($so->solution_id, $so->problem_id, $so->user_id, $so->lang_id, $so->check_type);
        $filename = basename($fullname);
        if (is_file($fullname) && is_readable($fullname) && (filesize($fullname) > 0)) {
            blog("Give name ".$filename);
            bot_checkout_solution($so->solution_id, -2);
            echo $filename;
            blog("Success");
        } else {
            echo "- file not found";
            blog("Warning: File not exists ".$fullname);
            bot_checkout_solution($so->solution_id, -2);
        }
    } else {
        echo "0 no solutions";
        blog("No solutions");
    }

    return intval($filename);
}

function bot_download_file($fullname, $filename = "") {
    $mime_type = (is_msie()) ? "application/octetstream" : "application/octet-stream";

    header("Content-Type: " . $mime_type);
    header("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");

    if ($filename == "") {
        $filename = basename($fullname);
    }

    header("Content-Disposition: attachment; filename=\"" . $filename . "\"");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Pragma: public");

    $size = @filesize($fullname);
    if(!gzip_enabled() && $size) {
        header("Content-Length: $size");
    }
    @readfile($fullname);
}

function bot_give_sfile($id) {
    $id = (int)$id;
    $so = db_query_object("SELECT solution_id,problem_id,user_id,lang_id,check_type " .
        "FROM {solutions} WHERE solution_id='$id' AND test_result='-2' LIMIT 1");
    if ($so && isset($so->solution_id) && $so->solution_id) {
        $fullname = solution_fullname($so->solution_id, $so->problem_id, $so->user_id, $so->lang_id, $so->check_type);
        $filename = basename($fullname);
        if (is_file($fullname) && is_readable($fullname) && (filesize($fullname) > 0)) {
            blog("Get $filename, ".filesize($fullname)." bytes");
            bot_checkout_solution($id, -2);
            db_query("UNLOCK TABLES"); /* UNLOCK TABLES *before* long time download */
            bot_download_file($fullname, $filename);
            blog("Success");
        } else {
            header("HTTP/1.1 404 Not Found");
            echo "Not Found";
            blog("Warning: File not exists ".$fullname);
        }
    } else {
        header("HTTP/1.1 404 Not Found");
        echo "Invalid solution";
        blog("Warning: Solution not found ".$id);
    }
}

function bot_download_solution($id) {
    db_query("LOCK TABLES {solutions} WRITE");
    if (true) {
        clearstatcache();
    }
    if ((int)$id) {
        bot_give_sfile($id);
    } else {
        bot_give_sname();
    }
    /* also, after bot_checkout_solution called
       "UNLOCK TABLES" before long time download */
    db_query("UNLOCK TABLES");
}

function bot_safe_checkout_solution($id) {
    $id = (int)$id;
    $size = false;
    if (isset($_GET['size'])) {
        $size = (int)$_GET['size'];
    }
    $checksum = "";
    if (isset($_GET['checksum'])) {
        $size = $_GET['checksum'];
    }
    blog("Safe checkout $id"); /*, $rows rows affected */
    db_query("LOCK TABLES {solutions} WRITE");
    $so = db_query_object("SELECT solution_id,problem_id,user_id,lang_id,check_type,checksum " .
        "FROM {solutions} WHERE solution_id='$id' AND test_result='-2' LIMIT 1");
    if ($so && isset($so->solution_id) && $so->solution_id) {
        $fullname = solution_fullname($so->solution_id, $so->problem_id, $so->user_id, $so->lang_id, $so->check_type);
        $filename = basename($fullname);
        if (is_file($fullname) && is_readable($fullname) && (filesize($fullname) > 0)) {
            do {
                if (($size !== false) && ($size != filesize($fullname))) {
                    echo "- can't checkout, size mismatch";
                    blog("Warning: Cannot checkout $id, size mismatch");
                    break;
                }
                if (($checksum != "") && ($checksum != $so->$checksum)) {
                    echo "- can't checkout, checksum mismatch";
                    blog("Warning: Cannot checkout $id, checksum mismatch");
                    break;
                }
                bot_checkout_solution($id);
                //$rows = db_affected_rows();
                //echo $rows;
                echo "1";
                blog("Success"); /*, $rows rows affected */
            } while (false);
        } else {
            echo "- can't checkout";
            blog("Warning: Cannot checkout $id, file not found");
        }
    } else {
        echo "- can't checkout";
        blog("Warning: Cannot checkout $id, solution not found");
    }
    db_query("UNLOCK TABLES");
}
function import_solutions() {
    return true;
}

function bot_commit_solution($so) {
    /* unlock before external operations */
    db_query("UNLOCK TABLES");
    // bot_checkout_solution($so->solution_id,-5);
    define('DOTSBOT_INCLUDED', true);
    include DIR_FS_INCLUDES . "import.php";
    /* force import */
    $impored = import_solutions(true);
    blog("Import $impored solutions");
    return true;
}

function bot_commit_from_file($so,$fileobj) {
    if (isset($_FILE[$fileobj])) {
        $filename = basename($_FILES[$attachment]['name']);
        $tmpname = $_FILES[$attachment]['tmp_name'];
        if (!file_exists($tmpname) || !is_readable($tmpname)) {
            blog("Warning: upload error, file not found");
            return false;
        }
    } else {
        echo "- invalid file object";
        blog("Warning: invalid file object $fileobj");
        return false;
    }
    if (intval($filename) != intval($so->solution_id)) {
        echo "- invalid filename";
        blog("Warning: invalid results filename $filename ".$so->solution_id);
        if (file_exists($tmpname)) @unlink($tmpname);
        return false;
    }
    if (filesize($tmpname) < RA_MIN_SIZE) {
        echo "- no results given";
        blog("Warning: no results given, size ".filesize($tmpname));
        if (file_exists($tmpname)) @unlink($tmpname);
        return false;
    }
    if (filesize($tmpname) > RA_MAX_SIZE) {
        echo "- attachment is too big";
        blog("Warning: attachment is too big ".filesize($tmpname));
        if (file_exists($tmpname)) @unlink($tmpname);
        return false;
    }

    $fullname = results_fullname_create($so->solution_id);
    $filename = basename($fullname);

    if (file_exists($fullname)) {
        echo "- file already exists";
        blog("Warning: results file already exists ".$fullname);
        if (file_exists($tmpname)) @unlink($tmpname);
        return false;
    }

    if(move_uploaded_file($tmpname, $fullname)) {
        chmod($filename, 0666);
        bot_commit_solution($so);
        blog("Move results ".$filename.", ".filesize($fullname)." bytes");
        echo "1 OK";
        return true;
    } else {
        echo "- can't move";
        blog("Warning: Cannot move uploaded file $tmpname to $fullname");
        return false;
    }
}
function make_path() {
    return true;
}

function bot_commit_from_string($so,$string) {
    if (mb_strlen($string) < RA_MIN_SIZE) {
        echo "- empty string";
        blog("Warning: no results given, size ".mb_strlen($string));
        return false;
    }
    if (mb_strlen($string) > RA_MAX_SIZE) {
        echo "- too big";
        blog("Warning: results is too big ".mb_strlen($string));
        return false;
    }

    $fullname = results_fullname_create($so->solution_id, true);
    $filename = basename($fullname);

    if (file_exists($fullname)) {
        echo "- file already exists";
        blog("Warning: results file already exists ".$filename);
        rename($fullname, $fullname.".".time());
    } else {
        make_path($fullname, true);
    }

    if($fp = fopen($fullname, "w+t")) {
        @flock($fp, LOCK_EX);
        fwrite($fp, $string);
        @flock($fp, LOCK_UN);
        fclose($fp);
        chmod($fullname, 0666);
        bot_commit_solution($so);
        blog("Save results ".$filename.", ".filesize($fullname)." bytes");
        echo "1 OK";
        return true;
    } else {
        echo "- can't create a file";
        blog("Warning: Cannot open results $fullname");
        return false;
    }
}

function bot_commit_resuts($id) {
    $id = (int)$id;
    if ($id == 0) $id = (int)r('solution_id');
    blog("Put results $id");
    db_query("LOCK TABLES {solutions} WRITE");
    $so = db_query_object("SELECT solution_id " .
        "FROM {solutions} WHERE solution_id='$id' AND test_result='-3' LIMIT 1");
    if ($id && $so && isset($so->solution_id) && $so->solution_id) {
        if (isset($_FILES['file'])) {
            bot_commit_from_file($so,'file');
        } else if ($results = r('results')) {
            bot_commit_from_string($so,$results);
        } else if ($post = get_raw_post_data())  {
            bot_commit_from_string($so,$post);
        } else {
            blog("Warning: No results data for $id");
            echo "- no data";
        }
    } else {
        echo "- solution not found";
        blog("Warning: Cannot commit results for $id, unchecked solution not found");
    }
    db_query("UNLOCK TABLES");
}

function bot_get_tests($id) {

    $fullname = DIR_FS_TESTSDB . $id . DIR_FS_TESTEXT;

    if (is_file($fullname) && is_readable($fullname) && (filesize($fullname) > 0)) {
        blog("Get tests $id, ".filesize($fullname)." bytes");
        bot_download_file($fullname);
        blog("Success");
    } else {
        header("HTTP/1.1 404 Not Found");
        echo "Not Found";
        blog("Warning: File not exists ".$fullname);
    }
}

function bot_show_status($id) {
    $lines = file(BOT_LOGFILE);
    $count = count($lines);
    $first = ($count > 100) ? $count - 100 : 0;
    for($i = $first; $i < $count; $i++)
        echo $lines[$i];
}

/* garbage collector, clear dead locks */
function bot_gc() {
    $time = time();
    $time2 = $time - 300;  //  5 min for download
    $time3 = $time - 600;  // 10 min for testing
    db_query("UPDATE {solutions} SET test_result='-1', checked_time='$time' ".
        "WHERE (test_result='-2' AND checked_time<'$time2') OR (test_result='-3' AND checked_time<'$time3')");
    $rows = db_affected_rows();
    if ($rows) {
        blog("GC $rows rows affected");
    }
}

function ip_mask($addr,$mask) {
    if (empty($mask)) {
        return true;
    }
    @list($ip,$bits) = explode('/', $mask);
    if (strpos($bits,'.')) {
        $bits = (ip2long($bits) ^ 0xffffffff) + 1;
    } else if ((int)$bits) {
        $bits = 1 << (32 - (int)$bits);
    } else {
        $bits = 1;
    }
    return (ip2long($ip) ^ ip2long($addr)) < $bits;
}

function bot_login($username, $password, $addr) {
    global $friends;
    $login = "$username:$password";
    foreach ($friends as $friend) {
        @list($userpass,$mask) = explode('@', $friend);
        if (($login==$userpass)&&ip_mask($addr,$mask))
            return true;
    }
    return false;
}


function http_auth() {
        return true;
}
        function get_param($n) {
            if (get_argv(0) == 'sess') {
                $n += 2;
            }
            return get_argv($n);
        }

function bot_main() {
    /* recognize what client want */
    $level = get_param(1);
    $param = get_param(2);
    /* select the way */
    switch(mb_substr($level, 0, 1)) {
        case 's': /* get solution    */
            bot_download_solution($param);
            break;
        case 'c':
        case 'l': /* lock solution   */
            bot_safe_checkout_solution($param);
            break;
        case 'u': /* unlock solution */
            bot_rollback_solution($param);
            break;
        case 'r': /* post resuts     */
            bot_commit_resuts($param);
            break;
        case 't':
            bot_get_tests($param);
            break;
        case 'b':
        case 'i': /* show system (or solution) status */
            bot_show_status($param);
            break;
        default:
            if ($level) {
                $msg = "Unknown bot action: ".$level;
                blog("Error: ".$msg);
                die($msg."\n");
            } else {
                echo "Dotsbot/1.0\n";
            }
    }
    if (rand(1,10)==5) {
        bot_gc();
    }
}

if (http_auth()) {
    header('Content-type: text/plain');
    bot_main();
} else {
    header('HTTP/1.0 403 Forbidden');
    error('Forbidden');
}


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
