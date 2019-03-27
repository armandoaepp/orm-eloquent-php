<?php
//Importamos el archivo autoload.php presente en nuestro directorio vendor require 'vendor/autoload.php';
require __DIR__.'/bootstrap/autoload.php';

// use App\Models\Categoria ;

// $categoria = new Categoria() ;
// $categoria->nombre = "Nueva Cat desde composer ELOQUENT" ;
// echo $categoria->save() ;


use App\Controllers\CategoriasController ;

$categorias = new CategoriasController();
$data = $categorias->getAll() ;

var_dump($data);