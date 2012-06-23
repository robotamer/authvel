<?php

Schema::create('users', function($table) {
    $table -> increments('id');
    $table -> string('username', 64);
    $table -> string('password', 64);
    $table -> string('email', 128);
});

DB::table('users') -> insert(array('username' => 'admin', 'password' => Hash::make('1234')));
?>