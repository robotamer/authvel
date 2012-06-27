<?php

if (!Config::get('access')) {
    include __dir__.'/config/access.php';
    Config::set('access', $access);
}

$i = Config::get('authvel::access');
var_export($i);
exit;

/**
 *
 *Password reset example
 * http://forums.laravel.com/viewtopic.php?id=1533
 */

/**
 * Guest filter
 * If is a guest send to login
 */
Route::filter('guests', function() {
    if (Auth::guest())
        return Redirect::to_route('auth_login');
});

/**
 * User filter, filters users out
 * If is a user send to seetings
 */
Route::filter('users', function() {
    if (Auth::check()) {
        return Redirect::to_route('auth_settings');
    }

});

/**
 * Find out how to check more then one filter
 * Need to check csrf and users
 */

Route::filter('csrf', function() {
    if (Request::forged())
        return Response::error('500');
});

/**
 * Lobby
 **/
Route::get('(:bundle)', array('as' => 'auth_lobby', function() {
    return View::make('layout') -> with('title', 'User Lobby') -> nest(Config::get('authvel::content'), 'authvel::lobby');
}));

/**
 * Login
 */
Route::get('(:bundle)/login', array('as' => 'auth_login', 'before' => 'users', 'do' => function() {
    return View::make('layout') -> with('title', 'Login') -> nest(Config::get('authvel::content'), 'authvel::login'); ;
}));

Route::post('(:bundle)/login', array('as' => 'auth_login_post', 'before' => 'users', 'do' => function() {
    $credentials = array('username' => Input::get('username'), 'password' => Input::get('password'));
    if (Auth::attempt($credentials)) {
        // auth success
        return Redirect::to_route('auth_settings');
    } else {
        // auth failed
        return Redirect::to_route('auth_login') -> with('messages', array('No match'));
    }
}));

/**
 * Signup
 */
Route::get('(:bundle)/signup', array('as' => 'auth_signup', 'before' => 'users', 'do' => function() {
    return View::make('layout') -> with('title', 'Signup') -> nest(Config::get('authvel::content'), 'authvel::signup'); ;
}));

Route::post('(:bundle)/signup', array('as' => 'auth_signup_post', 'before' => 'users', 'do' => function() {
    $rules = array('email' => 'required|email|unique:users,email');
    $validation = Validator::make(Input::all(), $rules);

    if ($validation -> fails()) {
        return Redirect::to_route('auth_signup') -> with_errors($validation);
    } else {
        $email = Input::get('email');

        $username = strstr($email, '@', TRUE) . rand(1000, 9999);
        $password = randString(6, TRUE);
        $user = new User;
        $user -> fill(array('username' => $username, 'password' => $password, 'email' => $email, 'access' => 0));
        $user -> save();
        Auth::login($user -> id);
        return Redirect::to_route('auth_lobby');
    }
}));

/**
 * Logout
 */
Route::get('(:bundle)/logout', array('as' => 'auth_logout', 'before' => 'guests', 'do' => function() {
    Auth::logout();
    return Redirect::to_route('auth_lobby');
}));

/**
 * Settings
 */
Route::get('(:bundle)/settings', array('as' => 'auth_settings', 'before' => 'guests', 'do' => function() {
    Session::put('username', Auth::user() -> username);
    return View::make('layout') -> with('title', 'Settings') -> nest(Config::get('authvel::content'), 'authvel::settings');
}));

Route::post('(:bundle)/settings', array('as' => 'auth_settings_post', 'before' => 'guest', 'do' => function() {

    $input = Input::all();
    if (isset($input['username'])) {
        $rules = array('username' => 'between:3,20|alpha_num|unique:users,username');
        $validation = Validator::make(Input::all(), $rules);
    }

    /**
     * Change Password
     */

    if (isset($input['password'])) {
        $rules = array('password' => 'min:5|confirmed');
        $validation = Validator::make(Input::all(), $rules);
    }

    $validation = Validator::make(Input::all(), $rules);

    if ($validation -> fails()) {
        return Redirect::to_route('auth_settings') -> with_errors($validation);
    } else {
        $user = User::find(Auth::user() -> id);
        if (isset($input['username'])) {
            $user -> username = $input['username'];
            $m = 'Your username has been changed';
        }
        if (isset($input['password'])) {
            $user -> password = $input['password'];
            $m = 'Your password has been changed';
        }
        if($user -> save()){
            Session::flash('info', $m);
        }else{
            Session::flash('error', 'Please try again');
        }
        
        return Redirect::to_route('auth_settings');
    }
}));

/**
 * Error
 */
Route::any('(:bundle)/error', function() {
    return View::make('layout') -> with('title', 'Error') -> nest(Config::get('authvel::content'), 'authvel::error');
});

/**
 * Readable param is good for captcha for example
 *
 * randString(rand(10,15));
 *
 * @category     RoboTamer
 * @author       Dennis T Kaplan
 * @copyright    Copyright (c) 2011, Dennis T Kaplan
 * @license      http://www.RoboTamer.com/license.php
 * @link         http://www.RoboTamer.com
 *
 * @version      1.3
 * @param        string $length
 * @param        bool   $readable
 * @return       string
 */
function randString($length = 6, $readable = FALSE) {
    if ($readable == FALSE) {
        $char = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    } else {
        $char = '23479ABCDEFHJLMNQRTUVWXYZabcefghijkmnopqrtuvwxyz';
    }
    $c = '';
    for ($i = 1; $i <= $length; $i++) {
        $c .= $char;
    }
    return substr(str_shuffle($c), 0, $length);
}

/**
 * Check if a user has access to the asset
 *
 * @param $lock string This is the lock on the asset. A comma seperated list
 * @param $keys array This are the keys / roles available to the user
 * @return boolern  TRUE or FALSE
 */

function CA($lock) {
    $check = FALSE;
    $lock = explode(',', str_replace(' ', '', $lock));
    $lock[] = 101;
    Log::write('debug', "Login Control 1");
    # Admin has always access
    $keys = Config::get('access');
    if ($keys !== FALSE) {
        $keys = explode(',', str_replace(' ', '', $keys));
    } else {
        Log::write('debug', "Login Control 45");
        $check = FALSE;
        redirect('/control_panel/login/', 'location');
    }

    foreach ($lock as $k => $v) {
        if (in_array($v, $keys)) {
            $check = TRUE;
        }
        if ($v == 100) {
            if (!in_array(100, $keys)) {
                Log::write('debug', "Login Control 50");
                redirect('/control_panel/login/', 'location');
                $check = FALSE;
            }
            Log::write('debug', "Login Control 60");
            $lock[$k] = FALSE;
        }
    }
    if ($check === TRUE) {
        return TRUE;
    } else {
        Log::write('debug', "You don't have access to this area.");
        Session::flash('error', "You don't have access to this area.");
    }
}
?>