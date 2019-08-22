
<?php
  $sidebar = array(
    "sidebar_class"  => "",
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
      Categorias
      </span>
    </li>
  </ol>
</nav>

<!-- begin:: Content -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12 mb-3">
      <a href="{{ route('admin-categorias') }}" class="btn btn-outline-secondary btn-sm btn-bar" role="button">
        <i class="fas fa-list-ul"></i>
        Listar
      </a>
      <a href="{{ route('categoria-new') }}" class="btn btn-outline-secondary btn-sm btn-bar" role="button">
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
          <i class="fa fa-align-justify"></i> Lista de categorias
        </div>
        <div class="card-body">
          <div class="table-responsive">

          <!--begin: Datatable -->
          <table class="table table-striped- table-bordered table-hover table-checkable table-sm" id="dataTableList">
            <thead>
              <tr>
                <th width="60"> Id </th> 
                <th> Descripcion </th>                 
                <th width="80"> Estado </th>
                <th width="80"> Publicar </th>
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

              if(!empty($row->cat_publicar)){
                if($row->cat_publicar == "S"){
                  $classBtn =  "btn-outline-danger";
                  $title = "Desactivar/Ocultar" ;
                  $icon_pub = '<i class="fas fa-times"></i>';
                }
                else {
                  $classBtn =  "btn-outline-success";
                  $title = "Publicar" ;
                  $icon_pub = '<i class="fas fa-check"></i>';
                }
              }

              /* estado */
              $title_estado = "";
              $class_estado = "";
              $class_disabled = "";

              if ($row->cat_estado == 0) {
                $title_estado = "Recuperar";
                $class_estado = "row-disabled";
                $class_disabled = "disabled";
              } else {
                $title_estado = "Eliminar";
              }


            ?>

              <tr class="<?php echo $class_estado; ?>">
                <td> {{ $row->id }} </td> 
                <td> {{ $row->cat_descripcion }} </td> 
                <td>
                  <span class="badge badge-pill <?php echo $status[$row->cat_estado]["class"] ?>"> 
                    <?php echo $status[$row->cat_estado]["title"] ?> 
                  </span>
                </td>
                <td class="text-center">
                 <span class="sr-only"><?php echo $row->cat_publicar; ?></span>
                 <button onclick="modalPublicar(<?php echo $row->id ?>, `<?php echo $row->cat_descripcion ?>` ,`<?php echo $title ?>`, `<?php echo $row->cat_publicar;  ?>`);" class="btn btn-sm lh-1 btn-table <?php echo $classBtn.' ' .$class_disabled; ; ?> " title="<?php echo $title; ?>" >
                   <?php echo $icon_pub ;?>
                 </button>
                </td>
                
                <td nowrap>
                  <a class="btn btn-outline-primary btn-sm lh-1 btn-table <?php echo $class_disabled; ?>"
                    href="{{ route('categoria-edit',['id' => $row->id]) }}" title="Editar">
                    <i class="fas fa-pencil-alt"></i>
                  </a>
                  <button class="btn btn-outline-danger btn-sm lh-1 btn-table"
                  onclick="modalDelete({{$row->id}}, `{{$row->cat_descripcion}}`,`<?php echo $title_estado ?>`,`{{$row->cat_estado}}`);" title="<?php echo $title_estado; ?>">
                    <i class="far fa-trash-alt"></i>
                  </button>
                  <span class="sr-only">
                    {{ $row->cat_estado }}
                  </span>
                </td>

              </tr>
            @endforeach
            </tbody>
          </table>

          <!--end: Datatable -->

          </div>
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

      let url_api = "{{ route('categoria-delete') }}";

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

    var text = `¿Esta seguro de <strong> ${title} </strong> categoria: <strong> ${textRow} </strong> ?`;
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

      let url_api_pub = "{{ route('categoria-publucar') }}";

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
  function modalPublicar(id, textRow, title, publicar) {
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
