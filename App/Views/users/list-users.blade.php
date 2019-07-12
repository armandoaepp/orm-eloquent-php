
<?php
  $sidebar = array(
    "sidebar_class" => "",
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );

?>

@extends('layouts.app-admin')

@section('content')

<div class="kt-subheader kt-grid__item" id="kt_subheader">
  <div class="kt-subheader__main">
    <h3 class="kt-subheader__title"> Users</h3>
    <span class="kt-subheader__separator kt-hidden"></span>
    <div class="kt-subheader__breadcrumbs">
      <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
      <span class="kt-subheader__breadcrumbs-separator"></span>
      <a href="#" class="kt-subheader__breadcrumbs-link">
        Maestros </a>
      <span class="kt-subheader__breadcrumbs-separator"></span>
      <a href="{{ route('admin-users') }}" class="kt-subheader__breadcrumbs-link">
      Users
      </a>
    </div>
  </div>
</div>

<!-- begin:: Content -->
<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
  <!-- begin:: Data List -->
  <div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head">
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">
          Lista de users
        </h3>
      </div>
    </div>
    <div class="kt-portlet__body position-relative">

    <div class="botonera mb-3">
      <a href="{{ route('admin-users') }}" class="btn btn-brand btn-elevate btn-elevate-air btn-sm" role="button">
        <i class="fas fa-list-ul"></i>
        Listar
      </a>
      <a href="{{ route('users-new') }}" class="btn btn-brand btn-elevate btn-elevate-air btn-sm" role="button">
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
          <tr>
              <th> Nombre </th> 
              <th> Apellidos </th> 
              <th> Email </th> 
              <th> Email Verified At </th> 
              <th> Password </th> 
              <th> Remember Token </th> 
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
          
              <td> {{ $row->nombre }} </td> 
              <td> {{ $row->apellidos }} </td> 
              <td> {{ $row->email }} </td> 
              <td> {{ $row->email_verified_at }} </td> 
              <td> {{ $row->password }} </td> 
              <td> {{ $row->remember_token }} </td> 
            <td>
              <span class="kt-badge <?php echo $status[$row->estado]["class"] ?> kt-badge--inline kt-badge--pill"> <?php echo $status[$row->estado]["title"] ?> </span>
            </td>
            <td nowrap> <span class="dropdown">
                <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
                  <i class="la la-ellipsis-h"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item <?php echo $class_disabled ?>" href="{{ route('users-edit',['id' => $row->id]) }}" title="Editar"><i class="la la-edit"></i> Editar</a>
                    <button class="dropdown-item" onclick="modalDelete({{$row->id}}, `{{$row->nombre}}`,`<?php echo $title_estado ?>`,`{{$row->estado}}`);" title="<?php echo $title_estado; ?>">
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

      let url_api = "{{ route('users-delete') }}";

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

    var text = `¿Esta seguro de <strong> ${title} </strong> de users: <strong> ${textRow} </strong> ?`;
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
