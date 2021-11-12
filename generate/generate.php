<?php



require __DIR__.'/../bootstrap/autoload.php';


use Illuminate\Database\Capsule\Manager as Capsule;

use Illuminate\Support\Str;

// use Doctrine\Common\Inflector\Inflector;
// use Doctrine\Inflector\Inflector;
// use Doctrine\Inflector\InflectorFactory;
use Doctrine\Inflector\Inflector;
use Doctrine\Inflector\NoopWordInflector;

$inflector = new Inflector(new NoopWordInflector(), new NoopWordInflector());


use App\Helpers\UrlHelper ;


require __DIR__.'/createFolders.php';

require __DIR__.'/model.php';
require __DIR__.'/controller.php';

require __DIR__.'/functionsControllers.php';
require __DIR__.'/helper.php';
require __DIR__.'/fieldsTable.php';
require __DIR__.'/validationRequest.php';


$fields_selected = $_POST['fields'] ;
$table_name      = $_POST["table_name"] ;
$fields_requireds = $_POST['requireds'] ;
// $table_name ='user' ;

if( empty( $table_name ) )
{
  echo "Table Name not found! <br>";
  return ;
}


$entities = [] ;

// entities de table
$entities = Capsule::select("describe ".$table_name);

// names all fields
$fields_col = array_column($entities, 'Field');

$class_name = $inflector->classify($table_name);
// $class_name = Inflector::classify($table_name);

# crear folder de APP
echo createFoldersApp()."<br>" ;

// Generation Model
echo generateModel($table_name, $class_name, $entities , $fields_col) ."<br>" ;

// Generation Controller
echo generateController($table_name, $class_name, $entities ) ."<br>" ;

// Generation Controller
echo generateValidationRequest($table_name, $class_name, $entities, $fields_col ) ."<br>" ;

// Generation VIEWS

$heads_table = [] ;
$fields_table = [] ;
$tipo_inputs = [] ;
for ($i = 0; $i < count($fields_selected); $i++)
{
  $item = explode("/", $fields_selected[$i]);

  $fields_table[] = $item[0];
  $heads_table[] = $_POST["header_table" . $item[1]];
  $tipo_inputs[] = $_POST["type_input" . $item[1]];
}

require __DIR__.'/generateViews.php';
echo generateView($table_name, $class_name, $entities, $fields_table, $heads_table, $tipo_inputs, $fields_requireds   ) ."<br>"   ;

// echo Str

// echo "<pre>";
// print_r($heads_table) ;
// print_r($tipo_inputs) ;
// echo "</pre>";

function toCamelCase($string) {

  $value = ucwords($string, "_");
  $value = str_replace('_', ' ', $value);
  return $value ;
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title> Generate: Tables Database </title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>

<main class="main">

  <div class="container">

    <div class="row">
      <div class="col-md-3">
        <a href="./index.php"> Regresar</a>
      </div>




    </div>
  </div>

</main>

</body>
</html>