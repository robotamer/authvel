<?php
/**
 Schema::create('users', function($table) {
 $table -> increments('id');
 $table -> string('username', 64);
 $table -> string('password', 64);
 $table -> string('email', 128);
 });

 DB::table('users') -> insert(array('username' => 'admin', 'password' => Hash::make('1234')));
 */

Route::filter('guests', function() {
    if (!Auth::check())
        return Redirect::to_route('auth_login');
});

Route::filter('users', function() {
    if (Auth::check())
        return Redirect::to_route('auth_settings');
});

Route::get('(:bundle)', array('as' => 'auth_lobby', 'before' => 'users', 'do' => function() {
    return View::make('auth::login');
}));
Route::get('(:bundle)/login', array('as' => 'auth_login', 'before' => 'users', 'do' => function() {
    return View::make('auth::login');
}));

Route::get('(:bundle)/logout', array('as' => 'auth_logout', 'before' => 'guests', 'do' => function() {
    Auth::logout();
    return Redirect::to_route('auth_login');
}));

Route::get('(:bundle)/settings', array('as' => 'auth_settings', 'before' => 'guests', 'do' => function() {
    return View::make('auth::settings');
}));

Route::post('(:bundle)/login', array('as' => 'auth_login_post', 'before' => 'guests', 'do' => function() {
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