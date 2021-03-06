
<?php
  $sidebar = array(
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );

?>

@extends('layouts.app-admin')

@section('content')

<nav class="full-content" aria-label="breadcrumb">
  <ol class="breadcrumb breadcrumb-shape breadcrumb-theme shadow-sm radius-0">
    <li class="breadcrumb-item">
      <a href="{{ route('admin') }}">
        <i class="fas fa-home"></i> Home
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Actividads
      </span>
    </li>
  </ol>
</nav>

<!-- begin:: Content -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12 mb-3">
      <a href="{{ route('admin-actividads') }}" class="btn btn-outline-secondary btn-sm btn-bar" role="button">
        <i class="fas fa-list-ul"></i>
        Listar
      </a>
      <a href="{{ route('actividad-create') }}" class="btn btn-outline-secondary btn-sm btn-bar" role="button">
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
          <i class="fa fa-align-justify"></i> Lista de actividads
        </div>
        <div class="card-body">
          <!-- <div class="table-responsive"> -->

          <!--begin: Datatable -->
          <table id="dataTableLists" class="table table-sm table-hover table-bordered dt-responsive nowrap" style="width: 100%;">
            <thead>
              <tr>
                <th width="60"> Id </th> 
                <th> Nombre </th> 
                <th> Horas </th> 
                <th> Descripcion </th> 
                <th width="80"> Publicado </th>
                <th width="80"> Estado </th>
                <th width="50"> Acciones </th>
              </tr>
            </thead>
            <tbody>

            @foreach ($data as $row)

            <?php

              /* publicar */
              $classBtn = "" ;
              $title    = "" ;
              $icon_pub = "" ;
              $publicado = "";

              if(!empty($row->act_publicar)){
                if($row->act_publicar == "S"){
                  $classBtn =  "btn-outline-danger";
                  $title = "Desactivar/Ocultar" ;
                  $icon_pub = '<i class="fas fa-times"></i>';
                  $publicado = '<span class="badge badge-pill badge-success"> SI </span>';
                }
                else {
                  $classBtn =  "btn-outline-success";
                  $title = "Publicar" ;
                  $icon_pub = '<i class="fas fa-check"></i>';
                  $publicado = '<span class="badge badge-pill badge-danger"> NO </span>';
                }
              }

              /* estado */
              $title_estado = "";
              $class_estado = "";
              $class_disabled = "";

              if ($row->act_estado == 0) {
                $title_estado = "Recuperar";
                $class_estado = "row-disabled";
                $class_disabled = "disabled";
              } else {
                $title_estado = "Eliminar";
              }


            ?>

              <tr class="<?php echo $class_estado; ?>">
                <td> {{ str_pad($row->id, 3, "0", STR_PAD_LEFT) }} </td> 
                <td> {{ $row->act_nombre }} </td> 
                <td> {{ $row->act_horas }} </td> 
                <td> {{ $row->act_descripcion }} </td> 
                <td class="text-center">
                  <?php echo $publicado; ?>
                </td>
                <td class="text-center">
                  <span class="badge badge-pill <?php echo $status[$row->act_estado]["class"] ?>"> 
                    <?php echo $status[$row->act_estado]["title"] ?> 
                  </span>
                </td>
                <td class="text-center">
                  <div class="dropdown">
                    <button class="btn btn-outline-primary btn-sm lh-1 btn-table dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item <?php echo $class_disabled; ?>"href="{{ route('actividad-edit',['id' => $row->id]) }}" >
                        <i class="far fa-edit"></i> Editar
                      </a>
                      <a class="dropdown-item " href="#" onclick="modalDelete(event,{{$row->id}}, `{{$row->act_nombre}}`,`<?php echo $title_estado ?>`,`{{$row->act_estado}}`);" title="<?php echo $title_estado; ?>" >
                        <i class="far fa-trash-alt"></i> <?php echo $title_estado; ?>
                      </a>
                      <a class="dropdown-item <?php echo $class_disabled; ?>" href="#" onclick="modalPublicar(event, <?php echo $row->id ?>, `<?php echo $row->act_nombre ?>` ,`<?php echo $title ?>`, `<?php echo $row->act_publicar;  ?>`);" >
                        <?php echo $icon_pub ;?> <?php echo $title; ?>
                      </a>
                    </div>
                  </div>
                </td>

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

@section('modal')

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


@section('script')

@include('shared.datatables')

<script>
  // modals
  (function ($) {
    function processFormModal(event) {

      event.preventDefault();
      $("#alertModal").html('');

      let inputs = $("#formModal").serializeFormJSON();
      inputs.id = $("#idRowModal").val();
      // let params = JSON.stringify(inputs);
      let params = inputs;

      let url_api = "{{ route('actividad-delete') }}";

      axios({
        method: 'post',
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

    var text = `¿Esta seguro de <strong> ${title} </strong> actividad: <strong> ${textRow} </strong> ?`;
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

      let url_api_pub = "{{ route('actividad-publish') }}";

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


@endsection
