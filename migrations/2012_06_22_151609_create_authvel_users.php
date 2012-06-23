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
            $table -> string('username', 64);
            $table -> string('password', 64);
            $table -> string('email', 128);
        });

        DB::table('users') -> insert(array('username' => 'admin', 'password' => Hash::make('1234')));
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
