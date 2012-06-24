<?php

class User extends Eloquent {

    /**
     * @ Pleace this in to config
     */
    public static $access = array('banned'=>-1,'not_verified'=>0,'user'=>1,'author'=>2,'admin'=>100);
    
    public static $timestamps = true;

    public function get_created() {
        return date('Y-m-d H:i', strtotime($this -> get_attribute('created_at')));
    }

    public function get_updated() {
        return date('Y-m-d H:i', strtotime($this -> get_attribute('updated_at')));
    }

    public function get_email() {
        return $this -> get_attribute('email');
    }

    /**
     * @todo plase access string in named array
     */
    public function get_access() {
        return $this -> get_attribute('access');
    }



    /**
     * Add password verification min lenght, alhanum etc
     */
    public function set_username($username) {
        $this -> set_attribute('username', Hash::make($username));
    }

    /**
     * Add email verification!
     */
    public function set_email($email) {
        return $this -> set_attribute('email',$email);
    }

    /**
     * Add password verification min lenght, alhanum etc
     */
    public function set_password($password) {
        $this -> set_attribute('password', Hash::make($password));
    }
}
?>