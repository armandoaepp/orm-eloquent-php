<?php

    require_once "../sesion_admin.php";

    loginRedirect("../login.php");

    require_once "../../app/autoload.php";

    $categoria_controller = new CategoriaController();

    $data = $categoria_controller->getAll();

    $title_page = "Categorias";

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <?php

    $setvar = array(
      "titulo"     => "$title_page",
      "follow"      => "",
      "description" => "Administrador",
      "keywords"    => "administrador",
      "active"      => [1,0]
    );

    $sidebar = array(
      "sidebar_class"     => "",
      "sidebar_toggle"      => "only",
      "sidebar_active"      => [1,0],
    );

    require_once "../layout/head_links.phtml";
  ?>

</head>

<body>
  <?php require "../layout/header.phtml"; ?>

  <div class="app-wrap">
    <?php require_once "../layout/sidebar.phtml";?>

    <main role="main" class="main">

      <nav class="full-content" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-shape shadow-sm radius-0">
          <li class="breadcrumb-item">
            <a href="admin">
              <i class="fas fa-home"></i> Home
            </a>
          </li>

          <li class="breadcrumb-item active bg-info text-white" aria-current="page">
            <a class="link-white" href="admin/categoria/categoria.php">
              <?php echo $title_page; ?>
            </a>
          </li>
        </ol>
      </nav>

      <div class="container-full p-2 fs-x-14">
        <div class="row">
          <div class="col-12">
            <h5 class="page-header-title">Lista de <?php echo $title_page; ?> </h5>
          </div>
          <div class="col-12 mb-3">
            <a href="admin/categoria/categoria.php" class="btn btn-outline-primary btn-sm btn-bar" role="button">
              <i class="fas fa-list-ul"></i>
              Listar
            </a>
            <a href="admin/categoria/nuevo.php" class="btn btn-outline-primary btn-sm btn-bar" role="button">
              <i class="fas fa-file"></i>
              Nuevo
            </a>
          </div>

          <div class="col-12">
            <div class="table-responsive">
            
            <table id="dataTableList" class="table table-striped table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th width="50">Id </th>
                  <th>Nombre </th>
                  <th>Url </th>
                  <th width="50" class="fs-x-13"> Publicar </th>
                  <th width="70"></th>
                </tr>
              </thead>

              <tbody>
                <?php foreach ($data as &$row) {?>

                  <?php
                    $classBtn = "" ;
                    $title    = "" ;
                    $icon_pub = "" ;

                    if(!empty($row->publicar)){
                      if($row->publicar == "S"){
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
                    $title_estado   = "";
                    $class_estado   = "";
                    $class_disabled = "";

                    if($row->estado == 1)
                    {
                      $title_estado = "Eliminar" ;
                    }
                    else
                    {
                      $title_estado   = "Recuperar" ;
                      $class_estado   = "row-disabled";
                      $class_disabled = "is-disabled";
                    }
                  ?>

                <tr class="<?php echo $class_estado ;?>" >
                
                  <td> <?php echo $row->id ?> </td>
                  <td> <?php echo $row->nombre ?> </td>
                  <td> <?php echo $row->url ?> </td>

                  <td class="text-center">
                    <span class="sr-only"><?php echo $row->publicar ?></span>
                    <button onclick="modalPublicar(<?php echo $row->id ?>, `<?php echo $row->nombre ?>` ,`<?php echo $title ?>`, `<?php echo $row->publicar ?>`);" class="btn btn-sm lh-1 btn-table <?php echo $classBtn.' ' .$class_disabled; ; ?> " title="<?php echo $title; ?>" >
                    <?php echo $icon_pub ;?>
                    </button>
                  </td>
            

                  <td class="text-center">
                    <a class="btn btn-outline-primary btn-sm lh-1 btn-table <?php echo $class_disabled ; ?>" href="admin/categoria/editar.php?id=<?php echo $row->id ?>" title="Editar">
                    <i class="fas fa-pencil-alt"></i>
                    </a>
                    <button class="btn btn-outline-danger btn-sm lh-1 btn-table" onclick="modalDelete(<?php echo $row->id ?>, `<?php echo $row->nombre ?>`,`<?php echo $title_estado ?>`,`<?php echo $row->estado ?>`);" title="<?php echo $title_estado ;?>">
                    <i class="far fa-trash-alt"></i>
                    </button>
                    <span class="sr-only"><?php echo $row->estado ?></span>
                  </td>
                </tr>
                <?php }?>
              </tbody>

            </table> 
            </div>
          </div>

        </div>

      </div>

    </main>

  </div>



  <?php require_once "../layout/foot_links.phtml"?>

  <!-- Modal Delete -->
  <form id="formModal">
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">
            <span> Eliminar </span>
              <?php echo $title_page; ?>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <input type="hidden" name="idRowModal" id="idRowModal">
            <input type="hidden" name="accion" id="accion">
            <input type="hidden" name="publicar" id="publicar">
            <input type="hidden" name="estado" id="estado">
            <div id="dataTextModal">
            </div>

            <div id="modalHistorial" class="d-none">
              <div class="col-12 my-3">
                <label for="si" class="text-bold "> Conservar en historial: </label>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="historial" id="si" value="1" checked="checked">
                  <label class="form-check-label" for="si">SI</label>
                </div>

                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="historial" id="no" value="0" >
                  <label class="form-check-label" for="no">NO</label>
                </div>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-outline-danger" id="btn-send">Eliminar </button>
            <div id="alertModal"></div>
          </div>
        </div>
      </div>
    </div>
  </form>

  <?php require_once "../layout/datatables.phtml"?>

  <script>

  // modals
  (function ($) {
    function processFormModal(event) {

      event.preventDefault();
      var inputs = $("#formModal").serializeFormJSON();
      inputs.id = $("#idRowModal").val();
      var params = JSON.stringify(inputs);

      $.ajax({
        url: "./app/api/categoria/IndexCategoria.php",
        dataType: "json",
        type: "post",
        contentType: "application/json",
        data: params,
        processData: false,
        success: function (data, textStatus, jQxhr) {

          if (!data.error && data.data) {
            $("#myModal").modal("hide");
            $("#formModal")[0].reset();
            location.reload();
          }
          else {
            $("#alertModal").html("Error en servidor: " + data.data);
          }

        },
        error: function (jqXhr, textStatus, errorThrown) {
          console.log(errorThrown);
        }
      });

      event.preventDefault();
    }

    $("#formModal").submit(processFormModal);

  })(jQuery);


  // modal DELETE
  function modalDelete(id, textRow, title, estado) {
    $("#idRowModal").val(id);
    $("#accion").val("delete");

    $("#modalHistorial").addClass("d-none");
    $("#modalTitle span").text("Eliminar");

    var text = `¿Esta seguro de <strong> ${title} </strong>: <strong> ${textRow} </strong> ?`;
    $("#dataTextModal").html(text);
    $("#btn-send").text(title);

    $("#estado").val(estado);
    $("#btn-send").addClass("btn-outline-danger");

    if (estado === "0") {
      $("#modalHistorial").addClass("d-none");
      $("#modalHistorial").removeClass("d-block");
    }
    else if (estado === "1") {
      $("#modalHistorial").addClass("d-block");
    }
    $("#myModal").modal("show");
  }


  // modal PUBLICAR
  function modalPublicar(id, textRow, title, publicar) {
    $("#idRowModal").val(id);
    $("#accion").val("publish");
    $("#publicar").val(publicar);

    $("#modalHistorial").addClass("d-none");
    $("#modalTitle span").text("Publicar");

    var text = `¿Esta seguro de <strong> ${title} </strong>: <strong> ${textRow} </strong> ?`;
    $("#dataTextModal").html(text);
    $("#btn-send").text(title);

    $("#btn-send").removeClass("btn-outline-success");
    $("#btn-send").removeClass("btn-outline-danger");

    if (publicar.toLowerCase() === "n") {
      $("#btn-send").addClass("btn-outline-success");
    }
    else{
      $("#btn-send").addClass("btn-outline-danger");
    }

    $("#myModal").modal("show");
  }

</script>

</body>

</html>
