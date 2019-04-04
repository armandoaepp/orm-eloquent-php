<?php

require __DIR__.'/../bootstrap/autoload.php';

require __DIR__.'/createFolders.php';
require __DIR__.'/functions.php';
require __DIR__.'/fieldsTable.php';


use Illuminate\Database\Capsule\Manager as Capsule;

use Illuminate\Support\Str;
use Doctrine\Common\Inflector\Inflector;

// $fields = $_POST['fields'] ;
// $table_name = $_POST["table"] ;
$table_name ='marca' ;

if( empty( $table_name ) )
{
  echo "Table Name not found! <br>";
  return ;
}

# crear folder de APP
echo createFoldersApp() ;

$entities = [] ;

// entities de table
$entities = Capsule::select("describe ".$table_name);

// names all fields
$fields_col = array_column($entities, 'Field');

$class_name = Inflector::classify($table_name);

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