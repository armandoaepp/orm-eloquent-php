<?php

require __DIR__.'/../bootstrap/autoload.php';

// use Illuminate\Database\Capsule\Manager as Capsule;

// $tables = Capsule::select('SHOW TABLES');

$fields = $_POST['fields'] ;



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
            print_r($fields);
          ?>
        </pre>
      </div>




    </div>
  </div>

</main>

</body>
</html>