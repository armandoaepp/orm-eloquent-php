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
$entities = Capsule::select("describe ".$table_name);

$class_name = Inflector::classify($table_name);

// $folder   = "./app/Models/";
$folder   = MODELS;

$file_name = $folder.$class_name ;

$ext = ".php" ;

$file_open      = fopen($file_name . $ext, "w");

$str = '<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class '.$class_name.' extends Model {

  protected $table = "'.$table_name.'";

  public $timestamps = false;

  protected $guarded = [\'id\'];

}
';

fwrite($file_open, $str);
fclose($file_open);
echo "Class Generation OK";