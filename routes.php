<?php

/**
 * Guest filter
 * If is a guest send to login 
 */
Route::filter('guests', function() {
    if ( Auth::guest())
        return Redirect::to_route('auth_login');
});

/**
 * User filter, filters users out
 * If is a user send to seetings
 */
Route::filter('users', function() {
    if ( Auth::check()){
        return Redirect::to_route('auth_settings');
    }
        
});

Route::get('(:bundle)', array('as' => 'auth_lobby', 'before' => 'users', 'do' => function() {
    return Redirect::to_route('auth_login');
}));

Route::get('(:bundle)/login', array('as' => 'auth_login', 'before' => 'users', 'do' => function() {
    return View::make('layout')-> with('title', 'Login')
        -> nest(Config::get('authvel::content'), 'authvel::login');;
}));

Route::get('(:bundle)/logout', array('as' => 'auth_logout', 'before' => 'guests', 'do' => function() {
    Auth::logout();
    return Redirect::to_route('auth_login');
}));

Route::get('(:bundle)/settings', array('as' => 'auth_settings', 'before' => 'guests', 'do' => function() {
    Session::put('username', Auth::user()->username);
    return View::make('layout')
            -> with('title', 'Settings')
            -> nest(Config::get('authvel::content'), 'authvel::settings');
}));

Route::post('(:bundle)/login', array('as' => 'auth_login_post', 'before' => 'users', 'do' => function() {
    $credentials = array('username' => Input::get('username'), 'password' => Input::get('password'));
    if (Auth::attempt($credentials)) {
        // auth success
        return Redirect::to_route('auth_settings');
    } else {
        // auth failed
        return Redirect::to_route('auth_login') -> with('login_errors', true);
    }
}));

Route::any('(:bundle)/error', function() {
    return View::make('layout')
            -> with('title', 'Error')
            -> nest(Config::get('authvel::content'), 'authvel::error');
});

/**
 * Check if a user has access to the asset
 * 
 * @param $lock string This is the lock on the asset. A comma seperated list
 * @param $keys array This are the keys / roles available to the user 
 * @return boolern  TRUE or FALSE
 */

function CA($lock, $keys) {
    $check = FALSE;
    $lock = explode(',', str_replace(' ', '', $lock));
    $lock[] = 101;
    Log::write('debug', "Login Control 1");
    # Admin has always access
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
        Session::flash('error',"You don't have access to this area.");
    }
}


?>