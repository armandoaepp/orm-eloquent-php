<?php
require __DIR__.'/../bootstrap/autoload.php';

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

  public function save( $params = array() )
  {
    extract($params) ;

    try
    {
      $id      = null ;
      $status  = false;
      $message = "";

      $'.$table_name.' = '.$class_name.'::where(["nombre" => $nombre])->first();

      if (empty($'.$table_name.'))
      {
        $'.$table_name.' = new '.$class_name.'();
        '.
        foreach()
        {

        }

        .'

        $'.$table_name.'->nombre   = $nombre;
        $'.$table_name.'->url      = $url;
        $'.$table_name.'->imagen   = $imagen;
        $'.$table_name.'->publicar = $publicar;

        $status = $'.$table_name.'->save();

        $id = $'.$table_name.'->id ;

        $message = "Operancion Correcta";

      } else {
        $message = "¡El Registro ya existe!";
      }

      $data = [
              "message" => $message,
              "status"  => $status,
              "data"    => $id,
            ];

      return $data ;
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }
  }


}
';

fwrite($file_open, $str);
fclose($file_open);
echo "Controllers Generation OK";