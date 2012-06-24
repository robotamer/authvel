#!/usr/bin/php

<?php
system('clear');

$dirviews = $_SERVER['HOME'].'/code/laravel/bundles/authvel/views/';

$views[] = 'lobby.php';
$views[] = 'login.blade.php';
$views[] = 'signup.blade.php';
$views[] = 'settings.blade.php';

foreach ($views as $v) {
	copy($dirviews.$v, $dirviews.$v.'.sample');
}

system("ls -al $dirviews");

?>