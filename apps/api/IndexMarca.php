<?php
// require_once '../../autoload.php';
require __DIR__.'/../../bootstrap/autoload.php';

$router = new AltoRouter();

// map homepage
$router->map( 'GET', '/', function() {
    require __DIR__ . '/views/home.php';
});

return ;

use App\Controllers\MarcaController ;

$suscrito_controller = new MarcaController() ;

$data = $suscrito_controller->getAll() ;
// print_r($data);

$jsn  = json_encode($data);
print_r($jsn) ;