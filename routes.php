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
    if ( Auth::check())
        return Redirect::to_route('auth_settings');
});


Route::get('(:bundle)', array('as' => 'auth_lobby', 'before' => 'users', 'do' => function() {
    return View::make('authvel::login');
}));
Route::get('(:bundle)/login', array('as' => 'auth_login', 'before' => 'users', 'do' => function() {
    return View::make('authvel::login');
}));

Route::get('(:bundle)/logout', array('as' => 'auth_logout', 'before' => 'guests', 'do' => function() {
    Auth::logout();
    return Redirect::to_route('auth_login');
}));

Route::get('(:bundle)/settings', array('as' => 'auth_settings', 'before' => 'guests', 'do' => function() {
    return View::make('authvel::settings');
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
?>