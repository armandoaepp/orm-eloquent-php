<?php

require __DIR__.'/../bootstrap/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$tables = Capsule::select('SHOW TABLES');

$entities = [] ;
if(!empty($_GET["table"]) )
{
 $table_name = $_GET["table"];
 $entities = Capsule::select("describe ".$table_name);
}
else{
  $table_name = "" ;
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
      <div class="col-md-2">
        <ul>

          <?php
            foreach ($tables as $table)
            {
              foreach ($table as $key => $value)
              {
                echo '
                  <li>
                    <a href="?table='.$value.'" > '.$value.'</a>
                  </li>
                  ';

              }
            }
          ?>

        </ul>
      </div>

      <div class="col-md-10">
      <h4> Generate: <strong class="text-primary"><?php echo $table_name; ?></strong> </h4>
        <form id="form1" action="generate.php" method="post">

        <input type="hidden" name="table_name" value="<?php echo $table_name; ?>">

          <table class="table table-sm">
            <thead>
              <tr>
              <th>Field
              <input type="button" name="bttodo" id="bttodo" value="Seleccionar Todo" onclick="ckb('form1','true')"/>
                  <input type="button" name="btlimpiar" id="btlimpiar" onclick="ckb('form1','false')" value="Limpiar Seleccion" />
              </th>
              <th>Head Table</th>
              <th>Type Input</th>
              <th>NULL</th>
              <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($entities as $index => $entity)
              {
              ?>
              <tr>
                <td>
                  <label for="field_<?php echo $index ;?>">
                    <input type="checkbox" name="fields[]" value="<?php echo $entity->Field."/".$index; ?>"  id="field_<?php echo $index ;?>" />
                    <?php echo $entity->Field ;?>
                  </label>
                </td>
                <td>
                  <input type="text" name="header_table<?=$index?>" id="header_table<?=$index?>" value="<?php echo $entity->Field;?>" size="15" class="form-control form-control-sm" />
                </td>
                <td>
                  <select class="custom-select custom-select-sm" name="type_input<?=$index?>" id="type_input<?=$index?>">
                    <option value="text">Text</option>
                    <option value="textarea">Text Area</option>
                    <option value="select">Select</option>
                    <option value="email">Email</option>
                    <option value="tel">Tel</option>
                    <option value="checkbox">Checkbox</option>
                    <option value="date">Date</option>
                    <option value="color">Color</option>
                    <option value="datetime-local">Datetime-Local</option>
                    <option value="file">File</option>
                    <option value="hidden">Didden</option>
                    <option value="image">Image</option>
                    <option value="month">Month</option>
                    <option value="number">Number</option>
                    <option value="password">Password</option>
                    <option value="radio">Radio</option>
                    <option value="range">Dange</option>
                    <option value="reset">reset</option>
                    <option value="search">Search</option>
                    <option value="time">Time</option>
                    <option value="url">Url</option>
                    <option value="week">Week</option>
                  </select>
                </td>
                <td>
                  <label for="input_required_<?php echo $index ;?>">
                    <!-- <input type="checkbox" name="requireds[]" value="<?php echo $entity->Field."/".$index; ?>" <?php if( $entity->Null == 'NO' ){ echo "checked" ; } ?> id="input_required_<?php echo $index ;?>" /> -->
                    <input type="checkbox" name="requireds[]" value="<?php echo $entity->Field."/".$index; ?>" <?php if( $entity->Null == 'NO' ){ echo "checked" ; } ?> id="input_required_<?php echo $index ;?>" />
                    <input type="radio" id="huey" name="drone" value="huey" checked>

                    <?php echo $entity->Null  ?>
                  </label>
                </td>
              </tr>

              <?php
              }
              ?>

            </tbody>
          </table>

          <button type="submit" class="btn btn-primary">Generar </button>
        </form>


      </div>


    </div>
  </div>

</main>

<script>
function ckb(frm,estado){
    form=document.getElementById(frm);
    var cant=form.elements.length;
    for(i=0;i<cant;i++){
      console.log(form.elements[i]);
      if(form.elements[i].type == "checkbox"){
        if(estado=="true"){form.elements[i].checked=true;}
        if(estado=="false"){form.elements[i].checked=false;}

      }
    }

  }
  </script>

</body>
</html>