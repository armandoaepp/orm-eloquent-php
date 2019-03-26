<?php
/*
|--------------------------------------------------------------------------
| Config Paths
|--------------------------------------------------------------------------
|
*/
require_once __DIR__.'/../config/paths.php' ;

/*
|--------------------------------------------------------------------------
| Config app
|--------------------------------------------------------------------------
|
*/
require_once __DIR__.'/../config/app.php' ;



/*
|--------------------------------------------------------------------------
| Register The Composer Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so we do not have to manually load any of
| our application's PHP classes. It just feels great to relax.
|
*/

require __DIR__.'/../vendor/autoload.php';


/*
|--------------------------------------------------------------------------
| Config database
|--------------------------------------------------------------------------
|
*/

require_once __DIR__.'/../config/database.php' ;