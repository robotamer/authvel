authvel
=======

Laravel Authentication

At any point if you find your self not understanding these instructions then maybe you should go here first:   
https://github.com/RoboTamer/learnvel

### This app should be considered "alfa"!

Add following line to application/bundles.php

    'authvel' => array('auto' => true, 'handles' => 'auth'),


Add following to application/start.php    

    Laravel\Event::listen('laravel.started: authvel', function() {
        Laravel\Config::set('authvel::username', 'admin');
        Laravel\Config::set('authvel::password', 'secret');
        Laravel\Config::set('authvel::content', 'content');
    });

In your layout file the login forms will be posted to the content varibale.

    echo $content

Creating the Laravel migrations table  
If you haven't done this for a different app already  

    php artisan migrate:install


Now we install authvel

    php artisan bundle:publish authvel
    php artisan bundle:install authvel
    php artisan migrate authvel

More info at:  
http://laravel.com/docs/database/migrations



Go to your site:
    http://laravel.dev/auth  

And login with admin:0711


Upgrading authvel

    php artisan bundle:upgrade authvel
    
