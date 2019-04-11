<?php
// require_once '../../autoload.php';
require __DIR__.'/../../bootstrap/autoload.php';

use App\Controllers\MarcaController ;

$suscrito_controller = new MarcaController() ;

$data = $suscrito_controller->getAll() ;
// print_r($data);

$jsn  = json_encode($data);
print_r($jsn) ;