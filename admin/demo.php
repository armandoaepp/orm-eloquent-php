<?php
//Importamos el archivo autoload.php presente en nuestro directorio vendor require 'vendor/autoload.php';
require __DIR__.'/../bootstrap/autoload.php';

// use App\Models\Categoria ;

// $categoria = new Categoria() ;
// $categoria->nombre = "Nueva Cat desde composer ELOQUENT" ;
// echo $categoria->save() ;


use App\Controllers\CategoriasController ;

use Illuminate\Support\Str;
// D:\xampp\htdocs\orm-eloquent-php\vendor\doctrine\inflector\lib\Doctrine\Common\Inflector\Inflector.php
use Doctrine\Common\Inflector\Inflector;

// try
//     {

      // $categorias = new CategoriasController();
      // $data = $categorias->getAll() ;

      // var_dump($data);
      echo Str::plural('producto')."<br>";

      echo Str::plural('cancion')."<br>";
      echo Str::plural('torres')."<br>";

      $converted = Str::camel('producto_detalle');
      echo $converted."<br>";

      $classify = Inflector::classify('producto_detalle');
      // $classify = Inflector::class('producto_detalle');
      // \Doctrine\Common\Inflector\Inflector
      // $word = 'producto_detalle';
      // $classify = str_replace([' ', '_', '-'], '', ucwords($word, ' _-'));
      echo $classify."<br>";




    // }
    // catch (Exception $e)
    // {
    //   echo $e->getMessage();
    // }


