<?php

require __DIR__ . '/../bootstrap/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$tables = Capsule::select('SHOW TABLES');

$entities = [];
if (!empty($_GET["table"])) {
  $table_name = $_GET["table"];
  $entities = Capsule::select("describe " . $table_name);
} else {
  $table_name = "";
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
            foreach ($tables as $table) {
              foreach ($table as $key => $value) {
                echo '
                  <li>
                    <a href="?table=' . $value . '" > ' . $value . '</a>
                  </li>
                  ';
              }
            }
            ?>

          </ul>
        </div>

        <div class="col-md-10">

          <form id="form1" action="generate.php" method="post">
          <h4> Generate: <strong class="text-primary"><?php echo $table_name; ?></strong>
            <label for="prefix_name" style=" font-size: 14px; margin-left: 8px; "><input name="prefix_name" id="prefix_name" type="checkbox"> Eliminar Prefijo</label>
          </h4>
            <input type="hidden" name="table_name" value="<?php echo $table_name; ?>">

            <table class="table table-sm">
              <thead>
                <tr>
                  <th>Field
                    <input type="button" name="bttodo" id="bttodo" value="Seleccionar Todo" onclick="ckb('form1', true)" />
                    <input type="button" name="btlimpiar" id="btlimpiar" onclick="ckb('form1', false)" value="Limpiar Seleccion" />
                  </th>
                  <th>Head Table</th>
                  <th>Type Input
                  </th>

                  <th><label for="checked-requireds">Not Null</label> <input id="checked-requireds" type="checkbox" name="check_required" /> </th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($entities as $index => $entity) {

                  $required_once = ($index == 0) ? 'required' : '';
                ?>
                  <tr>
                    <td>
                      <label for="field_<?php echo $index; ?>">
                        <input class="form-check-field" type="checkbox" <?php echo $required_once ?> name="fields[]" value="<?php echo $entity->Field . "/" . $index; ?>" id="field_<?php echo $index; ?>" />
                        <?php echo $entity->Field; ?>
                      </label>
                    </td>
                    <td>
                      <input type="text" name="header_table<?= $index ?>" id="header_table<?= $index ?>" value="<?php echo $entity->Field; ?>" size="15" class="form-control form-control-sm" />
                    </td>
                    <td>
                      <select class="custom-select custom-select-sm" name="type_input<?= $index ?>" id="type_input<?= $index ?>">
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
                    <td class="text-center">
                      <label for="input_required_<?php echo $index; ?>">
                        <!-- <input type="checkbox" name="requireds[]" value="<?php echo $entity->Field . "/" . $index; ?>" <?php if ($entity->Null == 'NO') {
                                                                                                                              echo "checked";
                                                                                                                            } ?> id="input_required_<?php echo $index; ?>" /> -->
                        <input class="form-check-required" type="checkbox" name="requireds[]" value="<?php echo $entity->Field ?>" <?php if ($entity->Null == 'NO') {
                                                                                                                                      echo "checked";
                                                                                                                                    } ?> id="input_required_<?php echo $index; ?>" />
                        <!-- <?php echo $entity->Null ?> -->
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

  <script src="https://code.jquery.com/jquery-3.4.1.slim.js" integrity="sha256-BTlTdQO9/fascB1drekrDVkaKd9PkwBymMlHOiG+qLI=" crossorigin="anonymous"></script>

  <script>
    function ckb(frm, estado) {

      $(".form-check-field").each(function(index) {
        console.log(index + ": " + $(this).val());
        // console.log(estado);
        if (estado == true) {
          $(this).prop('checked', true);
        }
        if (estado == false) {
          $(this).prop('checked', false);
        }

      });



      // form = document.getElementById(frm);
      // var cant = form.elements.length;
      // for (i = 0; i < cant; i++) {

      //   console.log(form.elements[i]);
      //   console.log(form.elements[i].class);
      //   if (form.elements[i].type == "checkbox") {
      //     if (estado == "true") {
      //       form.elements[i].checked = true;
      //     }
      //     if (estado == "false") {
      //       form.elements[i].checked = false;
      //     }

      //   }
      // }

    }

    //  checked requires checkbox
    $('#checked-requireds').change(function() {

      $checked = $(this).prop("checked");

      $(".form-check-required").each(function(index) {

        $(this).prop('checked', $checked);

      });
    });

    /* function ckb(frm,estado)
    {
        form=document.getElementById(frm);
        var cant=form.elements.length;
        for(i=0;i<cant;i++){
          console.log(form.elements[i]);
          if(form.elements[i].type == "checkbox"){
            if(estado=="true"){form.elements[i].checked=true;}
            if(estado=="false"){form.elements[i].checked=false;}

          }
        }

      } */
  </script>

</body>

</html>