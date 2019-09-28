<?php
function generateIndex($table_name, $class_name, $entities = array(), $fields_table, $heads_table = array() , $tipo_inputs = array() )
{
  $table_amigable = App\Helpers\UrlHelper::urlFriendly($table_name);

  $table_sin_guion = str_replace ('-', ' ', $table_amigable);

  $table_plural = str_plural($table_amigable) ;
  $title = ucwords(str_replace ('-', ' ', $table_plural));

  $prefix =  generatePrefixTable( $table_name ) ;
  $prefix = !empty($prefix) ? $prefix."_" : "" ;

  // field columns($entities);
  $fields_col = array_column($entities, 'Field');

$html = '
<?php
  $sidebar = array(
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );

?>

@extends(\'layouts.app-admin\')

@section(\'content\')

<nav class="full-content" aria-label="breadcrumb">
  <ol class="breadcrumb breadcrumb-shape breadcrumb-theme shadow-sm radius-0">
    <li class="breadcrumb-item">
      <a href="{{ route(\'admin\') }}">
        <i class="fas fa-home"></i> Home
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      '.$title.'
      </span>
    </li>
  </ol>
</nav>

<!-- begin:: Content -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12 mb-3">
      <a href="{{ route(\'admin-'.$table_plural.'\') }}" class="btn btn-outline-secondary btn-sm btn-bar" role="button">
        <i class="fas fa-list-ul"></i>
        Listar
      </a>
      <a href="{{ route(\''.$table_amigable.'-create\') }}" class="btn btn-outline-secondary btn-sm btn-bar" role="button">
        <i class="fas fa-file"></i>
        Nuevo
      </a>
    </div>

    <?php
      $status = [
        "0" => ["title" => "Eliminado", "class" => " badge-danger"],
        "1" => ["title" => "Activo", "class" => " badge-success"],
      ];
    ?>

    <div class="col-12">
      <div class="card">
        <div class="card-header bg-white">
          <i class="fa fa-align-justify"></i> Lista de '.$table_plural.'
        </div>
        <div class="card-body">
          <!-- <div class="table-responsive"> -->

          <!--begin: Datatable -->
          <table id="dataTableLists" class="table table-sm table-hover table-bordered dt-responsive nowrap" style="width: 100%;">
            <thead>
              <tr>' . PHP_EOL;
              for ($i=0; $i < count( $heads_table) ; $i++)
              {
                if ( !verificarItemNotListTable($fields_table[$i], $prefix) )
                {
                  $width = '' ;
                  if ($i == 0) {
                    $width = ' width="60"' ;
                  }

                  // ==== Start remove prefix
                  $field_item = $heads_table[$i] ;
                  if(!empty($prefix))
                  {
                    $field_item = revemoPrefix($field_item, $prefix)  ;
                  }
                  $field_item = toCamelCase($field_item);

                  // ==== Start remove prefix

                  $html .= '                <th'.$width.'> '.$field_item .' </th> '  . PHP_EOL ;
                }
              }

          $prefix_estado = (in_array("estado", $fields_table) ) ? 'estado' : $prefix."estado" ;
          $prefix_publicar = (in_array("publicar", $fields_table) ) ? 'publicar' : $prefix."publicar" ;

    $html .= '                <th width="80"> Publicado </th>' . PHP_EOL ;
    if(in_array("publicar", $fields_table) || in_array($prefix."publicar", $fields_table))
    {
      $html .= '                <th width="80"> Estado </th>' . PHP_EOL ;
    }

    $html .= '                <th width="50"> Acciones </th>' . PHP_EOL ;

    $html .= '              </tr>
            </thead>
            <tbody>

            @foreach ($data as $row)

            <?php

              /* publicar */
              $classBtn = "" ;
              $title    = "" ;
              $icon_pub = "" ;
              $publicado = "";

              if(!empty($row->'.$prefix_publicar.')){
                if($row->'.$prefix_publicar.' == "S"){
                  $classBtn =  "btn-outline-danger";
                  $title = "Desactivar/Ocultar" ;
                  $icon_pub = \'<i class="fas fa-times"></i>\';
                  $publicado = \'<span class="badge badge-pill badge-success"> SI </span>\';
                }
                else {
                  $classBtn =  "btn-outline-success";
                  $title = "Publicar" ;
                  $icon_pub = \'<i class="fas fa-check"></i>\';
                  $publicado = \'<span class="badge badge-pill badge-danger"> NO </span>\';
                }
              }

              /* estado */
              $title_estado = "";
              $class_estado = "";
              $class_disabled = "";

              if ($row->'.$prefix_estado.' == 0) {
                $title_estado = "Recuperar";
                $class_estado = "row-disabled";
                $class_disabled = "disabled";
              } else {
                $title_estado = "Eliminar";
              }


            ?>

              <tr class="<?php echo $class_estado; ?>">'. PHP_EOL;

              for ($i=0; $i < count( $fields_table) ; $i++)
              {
                if ( !verificarItemNotListTable($fields_table[$i], $prefix) )
                {
                  if($i == 0)
                  {
                    $html .= '                <td> {{ str_pad($row->'.$fields_table[$i].', 3, "0", STR_PAD_LEFT) }} </td> '. PHP_EOL;
                  }
                  else
                  {
                    $html .= '                <td> {{ $row->'.$fields_table[$i].' }} </td> '. PHP_EOL;
                  }
                }

              }

              if(in_array("publicar", $fields_table) || in_array($prefix."publicar", $fields_table))
              {
                $name_publicar = (in_array("publicar", $fields_table) ) ? 'publicar' : $prefix."publicar" ;
                $html .= '                <td class="text-center">'. PHP_EOL;
                $html .= '                  <?php echo $publicado; ?>'. PHP_EOL;
                $html .= '                </td>'. PHP_EOL;
              }


              $html .= '                <td class="text-center">'. PHP_EOL;
              $html .= '                  <span class="badge badge-pill <?php echo $status[$row->'.$prefix_estado.']["class"] ?>"> '. PHP_EOL;
              $html .= '                    <?php echo $status[$row->'.$prefix_estado.']["title"] ?> '. PHP_EOL;
              $html .= '                  </span>'. PHP_EOL;
              $html .= '                </td>'. PHP_EOL;

              $html .= '                <td class="text-center">'. PHP_EOL;
              $html .='                  <div class="dropdown">' .PHP_EOL ;
              $html .='                    <button class="btn btn-outline-primary btn-sm lh-1 btn-table dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' .PHP_EOL ;
              $html .='                        <i class="fas fa-ellipsis-h"></i>' .PHP_EOL ;
              $html .='                    </button>' .PHP_EOL ;
              $html .='                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">' .PHP_EOL ;
              $html .='                      <a class="dropdown-item <?php echo $class_disabled; ?>"href="{{ route(\''.$table_amigable.'-edit\',[\'id\' => $row->'.$fields_table[0].']) }}" >' .PHP_EOL ;
              $html .='                        <i class="far fa-edit"></i> Editar' .PHP_EOL ;
              $html .='                      </a>' .PHP_EOL ;
              $html .='                      <a class="dropdown-item " href="#" onclick="modalDelete(event,{{$row->'.$fields_table[0].'}}, `{{$row->'.$fields_table[1].'}}`,`<?php echo $title_estado ?>`,`{{$row->'.$prefix_estado.'}}`);" title="<?php echo $title_estado; ?>" >' .PHP_EOL ;
              $html .='                        <i class="far fa-trash-alt"></i> <?php echo $title_estado; ?>' .PHP_EOL ;
              $html .='                      </a>' .PHP_EOL ;

              if(in_array("publicar", $fields_table) || in_array($prefix."publicar", $fields_table))
              {
                $name_publicar = (in_array("publicar", $fields_table) ) ? 'publicar' : $prefix."publicar" ;
                $html .='                      <a class="dropdown-item <?php echo $class_disabled; ?>" href="#" onclick="modalPublicar(event, <?php echo $row->'. $fields_table[0] .' ?>, `<?php echo $row->'. $fields_table[1] .' ?>` ,`<?php echo $title ?>`, `<?php echo $row->'. $name_publicar .';  ?>`);" >' .PHP_EOL ;
                $html .='                        <?php echo $icon_pub ;?> <?php echo $title; ?>' .PHP_EOL ;
                $html .='                      </a>' .PHP_EOL ;
              }
              $html .='                    </div>' .PHP_EOL ;
              $html .='                  </div>' .PHP_EOL ;
              $html .= '                </td>'. PHP_EOL;

              /*if(in_array("publicar", $fields_table) || in_array($prefix."publicar", $fields_table))
              {
                $name_publicar = (in_array("publicar", $fields_table) ) ? 'publicar' : $prefix."publicar" ;

                $html .= '                <td class="text-center">' . PHP_EOL;
                $html .= '                 <span class="sr-only"><?php echo $row->'. $name_publicar .'; ?></span>' . PHP_EOL;
                $html .= '                 <button onclick="modalPublicar(event, <?php echo $row->'. $fields_table[0] .' ?>, `<?php echo $row->'. $fields_table[1] .' ?>` ,`<?php echo $title ?>`, `<?php echo $row->'. $name_publicar .';  ?>`);" class="btn btn-sm lh-1 btn-table <?php echo $classBtn.\' \' .$class_disabled; ; ?> " title="<?php echo $title; ?>" >' . PHP_EOL;
                $html .= '                   <?php echo $icon_pub ;?>' . PHP_EOL;
                $html .= '                 </button>' . PHP_EOL;
                $html .= '                </td>' . PHP_EOL;
              }*/


            /*$html .= '
                <td nowrap>
                  <a class="btn btn-outline-primary btn-sm lh-1 btn-table <?php echo $class_disabled; ?>" href="{{ route(\''.$table_amigable.'-edit\',[\'id\' => $row->'.$fields_table[0].']) }}" title="Editar">
                    <i class="fas fa-pencil-alt"></i>
                  </a>
                  <button class="btn btn-outline-danger btn-sm lh-1 btn-table" onclick="modalDelete(event,{{$row->'.$fields_table[0].'}}, `{{$row->'.$fields_table[1].'}}`,`<?php echo $title_estado ?>`,`{{$row->'.$prefix_estado.'}}`);" title="<?php echo $title_estado; ?>">
                    <i class="far fa-trash-alt"></i>
                  </button>
                  <span class="sr-only">
                    {{ $row->'.$prefix_estado.' }}
                  </span>
                </td>'.PHP_EOL ;*/
          $html .= '
              </tr>
            @endforeach
            </tbody>
          </table>
          <!--end: Datatable -->


          <!-- </div> -->
        </div>
      </div>
    </div>

  </div>

</div>

<!-- end:: Content -->
@endsection

@section(\'modal\')

<!-- Modal Delete -->
<form id="formModal">
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">
            <span> Eliminar </span>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @csrf
          <input type="hidden" name="idRowModal" id="idRowModal">
          <!-- <input type="hidden" name="publicar" id="publicar"> -->
          <input type="hidden" name="estado" id="estado">
          <div id="dataTextModal">
          </div>

          <div id="modalHistorial" class="d-none">
            <div class="col-12 my-3">
              <label for="si" class="text-bold "> Conservar en historial: </label>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="historial" id="si" value="si" checked="checked">
                <label class="form-check-label" for="si">SI</label>
              </div>

              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="historial" id="no" value="no">
                <label class="form-check-label" for="no">NO</label>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-outline-danger" id="btn-send">Eliminar </button>
        </div>
        <div class="modal-body py-0">
          <div id="alertModal" class="text-danger pb-3 boder-top"></div>
        </div>

      </div>
    </div>
  </div>
</form>

<!-- Modal Publicar -->
<form id="formModalPublicar">
  <div class="modal fade" id="myModalPublicar" tabindex="-1" role="dialog" aria-labelledby="myModalPublicarTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitlePublicar">
            <span> Publicar </span>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @csrf
          <input type="hidden" name="idPublicar" id="idPublicar">
          <input type="hidden" name="publicar" id="publicar">
          <div id="dataTextModalPublicar">
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-outline-danger" id="btn-send-publicar"> Desactivar</button>
        </div>
        <div class="modal-body py-0">
          <div id="alertModalPublicar" class="text-danger pb-3 boder-top"></div>
        </div>

      </div>
    </div>
  </div>
</form>

@endsection


@section(\'script\')

@include(\'shared.datatables\')

<script>
  // modals
  (function ($) {
    function processFormModal(event) {

      event.preventDefault();
      $("#alertModal").html(\'\');

      let inputs = $("#formModal").serializeFormJSON();
      inputs.id = $("#idRowModal").val();
      // let params = JSON.stringify(inputs);
      let params = inputs;

      let url_api = "{{ route(\''.$table_amigable.'-delete\') }}";

      axios({
        method: \'post\',
        url: url_api,
        data: params,
      }).then(function (response) {

        var data = response.data;

        if (data.status && data.data) {
          $("#myModal").modal("hide");
          $("#formModal")[0].reset();
          location.reload();
        }
        else if (!data.status && data.errors) {
          $("#alertModal").html("Error: " + data.message);
          console.log(data.errors);
        }
        else if (!data.status) {
          $("#alertModal").html("Error: " + data.message);
          console.log(data);
        }

      }).catch(function (error) {
        console.log(error);
      });
    }

    $("#formModal").submit(processFormModal);


  })(jQuery);

  // modal DELETE
  function modalDelete(event, id, textRow, title, estado) {

    event.preventDefault();

    $("#idRowModal").val(id);
    $("#accion").val("delete");

    $("#modalHistorial").addClass("d-none");
    $("#modalTitle span").text("Eliminar");

    var text = `¿Esta seguro de <strong> ${title} </strong> '. $table_sin_guion .': <strong> ${textRow} </strong> ?`;
    $("#dataTextModal").html(text);
    $("#btn-send").text(title);

    $("#estado").val(estado);
    $("#btn-send").addClass("btn-outline-danger");

    if (estado === "0") {
      $("#modalHistorial").addClass("d-none");
      $("#modalHistorial").removeClass("d-block");
    } else if (estado === "1") {
      $("#modalHistorial").addClass("d-block");
    }
    $("#myModal").modal("show");
  }
</script>' . PHP_EOL ;
if ( in_array('publicar', $fields_col) || in_array($prefix.'publicar', $fields_col) )
{

$html .= '
<script>
  // modals publicar
  (function ($)
  {
    /* Publicar */
    function processFormModalPublicar(event) {

      event.preventDefault();
      $("#alertModalPublicar").html("");

      let inputs = $("#formModalPublicar").serializeFormJSON();
      inputs.id = $("#idPublicar").val();
      // let params = JSON.stringify(inputs);
      let params = inputs;

      let url_api_pub = "{{ route(\''.$table_amigable.'-publish\') }}";

      axios({
        method: "post",
        url: url_api_pub,
        data: params,
      }).then(function (response) {

        var data = response.data;
        console.log(data);

        if (data.status && data.data) {
          $("#myModalPublicar").modal("hide");
          $("#formModalPublicar")[0].reset();
          location.reload();
        }
        else if (!data.status && data.errors) {
          $("#alertModalPublicar").html("Error: " + data.message);
          console.log(data.errors);
        }
        else if (!data.status) {
          $("#alertModalPublicar").html("Error: " + data.message);
          console.log(data);
        }

      }).catch(function (error) {
        console.log(error);
      });
    }

    $("#formModalPublicar").submit(processFormModalPublicar);

  })(jQuery);

  // modal PUBLICAR
  function modalPublicar(event, id, textRow, title, publicar) {

    event.preventDefault();

    $("#idPublicar").val(id);
    $("#publicar").val(publicar);

    var text = `¿Esta seguro de <strong> ${title} </strong>: <strong> ${textRow} </strong> ?`;
    $("#dataTextModalPublicar").html(text);
    $("#btn-send-publicar").text(title);

    $("#btn-send-publicar").removeClass("btn-outline-success");
    $("#btn-send-publicar").removeClass("btn-outline-danger");

    if (publicar.toLowerCase() === "n") {
      $("#btn-send-publicar").addClass("btn-outline-success");
      $("#modalTitlePublicar span").text("Publicar");
    }
    else{
      $("#btn-send-publicar").addClass("btn-outline-danger");
      $("#modalTitlePublicar span").text("Desactivar al Público");
    }

    $("#myModalPublicar").modal("show");
  }

</script>
' . PHP_EOL ;
}

$html .= '
@endsection
';

return $html ;
}