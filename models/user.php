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

    public function create($email) {
        $username = strstr($email, '@', TRUE) . rand(1000, 9999);
        $password = randString(6, TRUE);
        $this -> fill(array('username' => $username, 'password' => $password, 'email' => $email, 'access'=> 0));
        $this -> save();
        Auth::login($this);
    }

}

/**
 * Readable param is good for captcha for example
 *
 * randString(rand(10,15));
 *
 * @category     RoboTamer
 * @author       Dennis T Kaplan
 * @copyright    Copyright (c) 2011, Dennis T Kaplan
 * @license      http://www.RoboTamer.com/license.php
 * @link         http://www.RoboTamer.com
 *
 * @version      1.3
 * @param        string $length
 * @param        bool   $readable
 * @return       string
 */
function randString($length = 6, $readable = FALSE) {
    if ($readable == FALSE) {
        $char = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    } else {
        $char = '23479ABCDEFHJLMNQRTUVWXYZabcefghijkmnopqrtuvwxyz';
    }
    $c = '';
    for ($i = 1; $i <= $length; $i++) {
        $c .= $char;
    }
    return substr(str_shuffle($c), 0, $length);
}
?>