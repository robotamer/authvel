<?php

class User extends Eloquent {

    /**
     * @ Pleace this in to config
     */
    public static $access = array('banned' => -1, 'not_verified' => 0, 'user' => 1, 'author' => 2, 'admin' => 100);

    public static $timestamps = true;

    public function get_created() {
        return date('Y-m-d H:i', strtotime($this -> get_attribute('created_at')));
    }

    public function get_updated() {
        return date('Y-m-d H:i', strtotime($this -> get_attribute('updated_at')));
    }

    public function set_password($password) {
        $this -> set_attribute('password', Hash::make($password));
    }
}
?>