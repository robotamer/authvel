<?php

class Authvel_Create_Authvel_Users {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up() {

        Schema::create('users', function($table) {
            $table -> increments('id');
            $table -> string('username', 64) -> unique();
            $table -> string('password', 64);
            $table -> string('email', 128) -> unique();
            $table -> timestamps();
        });

        $user = Config::get('laravel.username', 'admin');
        $pass = Config::get('laravel.password', '1234');

        DB::table('users') -> insert(array('username' => $user, 'password' => Hash::make($pass)));
    }

    /**
     * Revert the changes to the database.
     *
     * @return void
     */
    public function down() {
        Schema::drop('users');
    }
}
