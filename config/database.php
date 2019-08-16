<?php

//Después importamos la clase Capsule escribiendo su ruta completa incluyendo el namespace
use Illuminate\Database\Capsule\Manager as Capsule;

//Creamos un nuevo objeto de tipo Capsule
$capsule = new Capsule;

//Indicamos en el siguiente array los datos de configuración de la BD
$capsule->addConnection([
 'driver'    => 'mysql',
 'host'      => 'localhost',
 'database'  => 'cat_db_hosting',
 'username'  => 'root',
 'password'  => '',
 'charset'   => 'utf8',
 'collation' => 'utf8_unicode_ci',
 'prefix'    => '',
]);

// Set the event dispatcher used by Eloquent models... (optional)
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
$capsule->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// //Y finalmente, iniciamos Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();