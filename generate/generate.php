<?php

require __DIR__.'/../bootstrap/autoload.php';

require __DIR__.'/createFolders.php';

require __DIR__.'/model.php';
require __DIR__.'/controller.php';

require __DIR__.'/functions.php';
require __DIR__.'/fieldsTable.php';

use Illuminate\Database\Capsule\Manager as Capsule;

use Illuminate\Support\Str;
use Doctrine\Common\Inflector\Inflector;

use App\Helpers\UrlHelper ;

$fields = $_POST['fields'] ;
$table_name = $_POST["table_name"] ;
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

$class_name = Inflector::classify($table_name);

# crear folder de APP
echo createFoldersApp()."<br>" ;

// Generation Model
echo generateModel($table_name, $class_name, $entities ) ."<br>" ;

// Generation Controller
echo generateController($table_name, $class_name, $entities ) ."<br>" ;

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
        <pre>
          <?php
            // print_r($fields);
          ?>
        </pre>
      </div>




    </div>
  </div>

</main>

</body>
</html>