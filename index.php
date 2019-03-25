<?php
//Importamos el archivo autoload.php presente en nuestro directorio vendor require 'vendor/autoload.php';
require 'vendor/autoload.php';

require "App/Config/Database.php" ;

use App\Models\Categoria ;

$categoria = new Categoria() ;
$categoria->nombre = "Nueva Cat desde composer ELOQUENT" ;
echo $categoria->save() ;