<?php

class Authvel_Create_Users {

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
            $table -> string('access', 128) -> nullable();
            $table -> blob('data');
            $table -> timestamps();
        });
        /*
         if(Config::get('database.default') == 'sqlite'){
         $sql = "CREATE TRIGGER users_insert_time AFTER INSERT ON users BEGIN UPDATE users SET creaded_at = datetime('NOW','UTC') WHERE rowid = last_insert_rowid(); END; ";
         $sql .= "CREATE TRIGGER users_update_time AFTER UPDATE ON users BEGIN UPDATE users SET updated_at = datetime('NOW','UTC') WHERE rowid = last_insert_rowid(); END;";
         $success = DB::query($sql);
         }
         */
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
