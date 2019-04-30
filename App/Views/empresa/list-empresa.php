
<?php
  $sidebar = array(
    "sidebar_class" => "",
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );

?>

@extends('layouts.app-admin')

@section('content')
<nav class="full-content" aria-label="breadcrumb">
  <ol class="breadcrumb breadcrumb-shape shadow-sm radius-0">
    <li class="breadcrumb-item">
      <a href="{{ route('admin') }}">
        <i class="fas fa-home"></i> Home
      </a>
    </li>

    <li class="breadcrumb-item active bg-info text-white" aria-current="page">
      <a class="link-white" href="{{ route('admin-empresas') }}">
        Empresas
      </a>
    </li>
  </ol>
</nav>
<div class="container-fluid">
  <div class="row">
    <div class="col-12 mb-3">
      <a href="{{ route('admin-empresas') }}" class="btn btn-outline-secondary btn-sm btn-bar" role="button">
        <i class="fas fa-list-ul"></i>
        Listar
      </a>
      <a href="{{ route('empresa-new') }}" class="btn btn-outline-secondary btn-sm btn-bar" role="button">
        <i class="fas fa-file"></i>
        Nuevo
      </a>
    </div>

    <div class="col-12">
      <div class="card">
        <div class="card-header bg-white">
          <i class="fa fa-align-justify"></i> Lista de Empresas
        </div>
        <div class="card-body">
          <div class="table-responsive">

            <table id="dataTableList" class="table table-striped table-bordered table-hover table-sm"
              style="width:100%">
              <thead>
                <tr>
                  <th width="50"> empresa_id </th> 
                  <th width="50"> ruc </th> 
                  <th width="50"> razonsocial </th> 
                  <th width="50"> direccion </th> 
                  <th width="50"> telefono </th> 
                  <th width="50"> celular </th> 
                  <th width="50"> paginaweb </th> 
                  <th width="50"> estado </th> 
                </tr>
              </thead>


              <tbody>
                @foreach ($data as $row)

                <?php

                  /* estado */
                  $title_estado = "";
                  $class_estado = "";
                  $class_disabled = "";

                  if ($row->estado == 1) {
                    $title_estado = "Eliminar";
                  } else {
                    $title_estado = "Recuperar";
                    $class_estado = "row-disabled";
                    $class_disabled = "is-disabled";
                  }
                ?>

                <tr class="<?php echo $class_estado; ?>">
                  <td> {{ $row->empresa_id }} </td> 
                  <td> {{ $row->ruc }} </td> 
                  <td> {{ $row->razonsocial }} </td> 
                  <td> {{ $row->direccion }} </td> 
                  <td> {{ $row->telefono }} </td> 
                  <td> {{ $row->celular }} </td> 
                  <td> {{ $row->paginaweb }} </td> 
                  <td> {{ $row->estado }} </td> 
                  <td class="text-center">
                  <a class="btn btn-outline-primary btn-sm lh-1 btn-table <?php echo $class_disabled; ?>" href="{{ route('empresa-edit',['id' => $row->empresa_id]) }}" title="Editar">
                      <i class="fas fa-pencil-alt"></i>
                    </a>
                    <button class="btn btn-outline-danger btn-sm lh-1 btn-table" onclick="modalDelete({{$row->empresa_id}}, `{{$row->ruc}}`,`<?php echo $title_estado ?>`,`{{$row->estado}}`);" title="<?php echo $title_estado; ?>">
                      <i class="far fa-trash-alt"></i>
                    </button>
                    <span class="sr-only">
                      {{ $row->estado }}
                    </span>
                  </td>
                </tr>
                @endforeach
              </tbody>

            </table>

          </div>
        </div>
      </div>
    </div>

  </div>

</div>


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

      let url_api = "{{ route('empresa-delete') }}";

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
  function modalDelete(id, textRow, title, estado) {
    $("#idRowModal").val(id);
    $("#accion").val("delete");

    $("#modalHistorial").addClass("d-none");
    $("#modalTitle span").text("Eliminar");

    var text = `¿Esta seguro de <strong> ${title} </strong> el Plan: <strong> ${textRow} </strong> ?`;
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
