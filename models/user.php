<?php

class User extends Eloquent {

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
     * Add email verification!
     */
    public function set_email($email) {
        return $this -> set_attribute($email);
    }

    /**
     * Add password verification min lenght, alhanum etc
     */
    public function set_password($password) {
        $this -> set_attribute('password', Hash::make($password));
    }

}
?>