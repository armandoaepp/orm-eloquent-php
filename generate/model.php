<?php
require __DIR__.'/../bootstrap/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$entities = [] ;

if(!empty($_GET["table"]) )
{
 $table_name = $_GET["table"];
 $entities = Capsule::select("describe ".$table_name);


  // foreach ($entities as $index => $entity)
  // {
  //   echo $entity->Field. "<br>" ;
  // }

}
else{
  $table_name = "" ;
}

$file_name = "demo" ;

$ext = "php" ;

$texto = '' ;
$text_demo = ' KFASDFJK' ;

$abrir      = fopen($file_name . $ext, "w");
$texto .= '<?php'.PHP_EOL;
$texto .= ' {$text_demo} '.PHP_EOL;

$texto .= '?>'.PHP_EOL;

// $str = <<<EOD
// <php
// <?php
// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class Categoria extends Model {

//   protected $table = 'categoria';

// }


// ?>
// EOD;

$foo = "bar";
echo <<<STR
str $foo
STR;

echo <<<'STR'
str $foo
STR;

fwrite($abrir, $str);
fclose($abrir);
echo "Clase Generada Correctamente";