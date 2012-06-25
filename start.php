<?php

Autoloader::namespaces(array('Authvel' => Bundle::path('authvel') . 'models', ));

//path('app').'libraries',
Autoloader::directories(array(__DIR__ . '/models'));
?>