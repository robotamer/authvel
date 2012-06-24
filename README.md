authvel
=======

Laravel Authentication

### This bundle should be considered "alfa"!

#### Install

Add following line to application/bundles.php

    'authvel' => array('auto' => true, 'handles' => 'auth'),


Add following to application/start.php    

    Laravel\Event::listen('laravel.started: authvel', function() {
        Laravel\Config::set('authvel::username', 'admin');
        Laravel\Config::set('authvel::password', 'secret');
        Laravel\Config::set('authvel::email',    'you@example.com');
        Laravel\Config::set('authvel::content',  'content');
    });

In your layout file the login forms will be posted to the **content** varibale.

    echo $content

Next creating the Laravel migrations table  

    php artisan migrate:install


Now we can install authvel

    php artisan bundle:publish authvel
    php artisan bundle:install authvel
    php artisan migrate authvel

More info at:  
http://laravel.com/docs/database/migrations

Let's go to the ``bundles/authvel/views`` folder and rename the sample files
You can edit the renamed files to fit your needs, they will not be overwritten when you upgrade

Finally, go to your site: ''replace the domain part with yor setup``
    http://laravel.dev/auth  

And login with admin:secret or what ever you specified your secret to be in the config 


#### Upgrade
This part is easy, thanks to Laravel

    php artisan bundle:publish authvel
    php artisan bundle:upgrade authvel
    
Go to the ``bundles/authvel/views`` folder and check for any upgrades to the sample files