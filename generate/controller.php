<?php

function generateController($table_name, $class_name, $entities = array() )
{
  // var_dump($entities);
  $fields_col = array_column($entities, 'Field');

  $class_controller = $class_name.'Controller' ;

  $folder   = CONTROLLERS;

  $file_name = $folder.$class_controller ;

  $ext = ".php" ;
  $file_open = fopen($file_name . $ext, "w");

  $str = '<?php
  namespace App\Controllers;

  /**
   * [Class Controller]
   * Autor: Armando E. Pisfil Puemape
   * twitter: @armandoaepp
   * email: armandoaepp@gmail.com
  */

  use App\Models\\'.$class_name.';

  class '.$class_controller.' {

    public function __construct() {}

    public function getAll()
    {
      try
      {

        $data = '.$class_name.'::get();

        return $data ;
      }
      catch (Exception $e)
      {
        throw new Exception($e->getMessage());
      }
    }
    ';
  $str .=  save($table_name, $class_name, $entities);
  $str .=  update($table_name, $class_name, $entities);
  $str .=  find($table_name, $class_name, $entities);
  $str .=  delete($table_name, $class_name, $entities);

  if ( in_array('estado', $fields_col) )
  {
    $str .=  updateStatus($table_name, $class_name, $entities);
    $str .=  getByStatus($table_name, $class_name, $entities);
  }

  if ( in_array('publish', $fields_col) )
  {
    $str .=  updatePublish($table_name, $class_name, $entities);
    $str .=  getPublished($table_name, $class_name, $entities);
  }

  $str .= '}';

  fwrite($file_open, $str);
  fclose($file_open);
  return "Class Controllers Generation OK";

}





/* require __DIR__.'/../bootstrap/autoload.php';
require __DIR__.'/functions.php';
require __DIR__.'/fieldsTable.php';

use Illuminate\Database\Capsule\Manager as Capsule;

use Illuminate\Support\Str;
use Doctrine\Common\Inflector\Inflector;

$entities = [] ;

if(empty($_GET["table"]) )
{

  return "Table Name not found!";

}

$table_name = $_GET["table"];
// entities de table
$entities = Capsule::select("describe ".$table_name);

// var_dump($entities);
$fields_col = array_column($entities, 'Field');


$class_name = Inflector::classify($table_name);
$class_controller = $class_name.'Controller' ;


// $folder   = "./app/Models/";
$folder   = CONTROLLERS;

$file_name = $folder.$class_controller ;

$ext = ".php" ;

$file_open      = fopen($file_name . $ext, "w");

$str = '<?php
namespace App\Controllers;



use App\Models\\'.$class_name.';

class '.$class_controller.' {

  public function __construct() {}

  public function getAll()
  {
    try
    {

      $data = '.$class_name.'::get();

      return $data ;
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }
  }
  ';
$str .=  save();
$str .=  update();
$str .=  find();
$str .=  delete();

if ( in_array('estado', $fields_col) )
{
  $str .=  updateStatus();
  $str .=  getByStatus();
}

if ( in_array('publish', $fields_col) )
{
  $str .=  updatePublish();
  $str .=  getPublished();
}

$str .= '
}
';

fwrite($file_open, $str);
fclose($file_open);
echo "Controllers Generation OK"; */