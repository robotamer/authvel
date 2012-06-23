<?php

Autoloader::namespaces(array('Authvel' => Bundle::path('authvel') . 'models', ));

Autoloader::directories(array(__DIR__ . '/models',
//path('app').'libraries',
));
?>