<?php
// require_once '../../autoload.php';
require __DIR__.'/../bootstrap/autoload.php';

$router = new AltoRouter();
$router->setBasePath('/orm-eloquent-php/public/');

// var_dump($router);

// map homepage
$router->map( 'GET', '/', function() {
    require __DIR__ . '/app/views/mail.html';
    // echo "prueba demo";
});

return ;