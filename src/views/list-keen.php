<?php
use Illuminate\Support\Str;

function generateIndex($table_name, $class_name, $entities = array(), $fields_table, $heads_table = array() , $tipo_inputs = array() )
{
  $table_amigable = App\Helpers\UrlHelper::urlFriendly($table_name);
  $table_plural = Str::plural($table_amigable) ;

  // $title = str_replace ('-', ' ', $table_plural);
  $title = ucwords(str_replace ('-', ' ', $table_plural));

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
  <ol class="breadcrumb breadcrumb-shape shadow-sm radius-0">
    <li class="breadcrumb-item">
      <a href="{{ route(\'admin\') }}">
        <i class="fas fa-home"></i> Home
      </a>
    </li>

    <li class="breadcrumb-item active bg-info text-white" aria-current="page">
      <a class="link-white" href="{{ route(\'admin-'.$table_plural.'\') }}">
      '.$title.'
      </a>
    </li>
  </ol>
</nav>


<!-- begin:: Content -->
<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
  <!-- begin:: Data List -->
  <div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head">
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">
          Lista de '.$table_plural.'
        </h3>
      </div>
    </div>
    <div class="kt-portlet__body position-relative">

    <div class="botonera mb-3">
      <a href="{{ route(\'admin-'.$table_plural.'\') }}" class="btn btn-brand btn-elevate btn-elevate-air btn-sm" role="button">
        <i class="fas fa-list-ul"></i>
        Listar
      </a>
      <a href="{{ route(\''.$table_amigable.'-create\') }}" class="btn btn-brand btn-elevate btn-elevate-air btn-sm" role="button">
        <i class="fas fa-file"></i>
        Nuevo
      </a>
    </div>
        <?php
          $status = [
            "0" => ["title" => "Eliminado", "class" => " kt-badge--danger"],
            "1" => ["title" => "Activo", "class" => " kt-badge--success"],
            "2" => ["title" => "Activo", "class" => " kt-badge--success"],
          ];
        ?>

      <!--begin: Datatable -->
      <table class="table table-striped- table-bordered table-hover table-checkable table-sm" id="dataTableList">
        <thead>
          <tr>';
          for ($i=0; $i < count( $heads_table) ; $i++)
          {
            if ( !verificarItemForm($fields_table[$i]) )
            {
              $width = '' ;
              if ($i == 0) {
                $width = ' width="60"' ;
              }

              $html .= '
              <th'.$width.'> '.toCamelCase($heads_table[$i]).' </th> ';
            }
          }

$html .= '
            <th width="80">Estado </th>
            <th width="50"> Acciones </th>
          </tr>
        </thead>
        <tbody>

        @foreach ($data as $row)

        <?php

          /* estado */
          $title_estado = "";
          $class_estado = "";
          $class_disabled = "";

          if ($row->estado == 0) {
            $title_estado = "Recuperar";
            $class_estado = "row-disabled";
            $class_disabled = "disabled";
          } else {
            $title_estado = "Eliminar";
          }


        ?>

          <tr class="<?php echo $class_estado; ?>">
          ';

          for ($i=0; $i < count( $fields_table) ; $i++)
          {
            if ( !verificarItemForm($fields_table[$i]) )
            {
              $html .= '
              <td> {{ $row->'.$fields_table[$i].' }} </td> ';
            }

          }
        $html .= '
            <td>
              <span class="kt-badge <?php echo $status[$row->estado]["class"] ?> kt-badge--inline kt-badge--pill"> <?php echo $status[$row->estado]["title"] ?> </span>
            </td>
            <td nowrap> <span class="dropdown">
                <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
                  <i class="la la-ellipsis-h"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item <?php echo $class_disabled ?>" href="{{ route(\''.$table_amigable.'-edit\',[\'id\' => $row->'.$fields_table[0].']) }}" title="Editar"><i class="la la-edit"></i> Editar</a>
                    <button class="dropdown-item" onclick="modalDelete({{$row->'.$fields_table[0].'}}, `{{$row->'.$fields_table[1].'}}`,`<?php echo $title_estado ?>`,`{{$row->estado}}`);" title="<?php echo $title_estado; ?>">
                      <i class="flaticon-delete"></i> <?php echo $title_estado ?>
                    </button>

                </div>
            </span>
            </td>

          </tr>
        @endforeach
        </tbody>
      </table>

      <!--end: Datatable -->
    </div>
  </div>

  <!-- end:: Data List -->

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
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-outline-danger" id="btn-send">Eliminar </button>
        </div>
        <div class="modal-body py-0">
          <div id="alertModal" class="text-danger pb-3 boder-top"></div>
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
  function modalDelete(id, textRow, title, estado) {
    $("#idRowModal").val(id);
    $("#accion").val("delete");

    $("#modalHistorial").addClass("d-none");
    $("#modalTitle span").text("Eliminar");

    var text = `¿Esta seguro de <strong> ${title} </strong> de '.$table_plural .': <strong> ${textRow} </strong> ?`;
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

</script>

@endsection
';

return $html ;
}