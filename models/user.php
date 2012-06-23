<?php
class User extends Eloquent {

    public static $timestamps = true;

    public function get_created() {
        return date('Y-m-d H:i', strtotime($this -> get_attribute('created')));
    }

    public function get_updated() {
        return date('Y-m-d H:i', strtotime($this -> get_attribute('updated')));
    }

    public function set_password($password) {
        $this -> set_attribute('password', Hash::make($password));
    }

}
?>