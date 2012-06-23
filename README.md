authvel
=======

Laravel Authentication

At any point if you find your self not understanding these instructions then maybe you should go here first:   
https://github.com/RoboTamer/learnvel

### This app should be considered "alfa"!

Add following line to application/bundles.php

    'authvel' => array('auto' => true, 'handles' => 'auth'),


Creating the Laravel migrations table  
If you haven't done this for a different app already  

    php artisan migrate:install


Now we install authvel

    php artisan bundle:install authvel
    php artisan migrate authvel

More info at:  
http://laravel.com/docs/database/migrations



Go to your site:
    http://laravel.dev/auth  

And login with admin:0711