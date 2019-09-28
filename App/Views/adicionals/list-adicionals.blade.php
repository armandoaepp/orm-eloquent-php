
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
      Adicionals
      </span>
    </li>
  </ol>
</nav>

<!-- begin:: Content -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12 mb-3">
      <a href="{{ route('admin-adicionals') }}" class="btn btn-outline-secondary btn-sm btn-bar" role="button">
        <i class="fas fa-list-ul"></i>
        Listar
      </a>
      <a href="{{ route('adicional-create') }}" class="btn btn-outline-secondary btn-sm btn-bar" role="button">
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
          <i class="fa fa-align-justify"></i> Lista de adicionals
        </div>
        <div class="card-body">
          <!-- <div class="table-responsive"> -->

          <!--begin: Datatable -->
          <table id="dataTableLists" class="table table-sm table-hover table-bordered dt-responsive nowrap" style="width: 100%;">
            <thead>
              <tr>
                <th width="60"> Id </th> 
                <th> Descripcion </th> 
                <th> Precio </th> 
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

              if(!empty($row->adi_publicar)){
                if($row->adi_publicar == "S"){
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

              if ($row->adi_estado == 0) {
                $title_estado = "Recuperar";
                $class_estado = "row-disabled";
                $class_disabled = "disabled";
              } else {
                $title_estado = "Eliminar";
              }


            ?>

              <tr class="<?php echo $class_estado; ?>">
                <td> {{ str_pad($row->id, 3, "0", STR_PAD_LEFT) }} </td> 
                <td> {{ $row->adi_descripcion }} </td> 
                <td> {{ $row->adi_precio }} </td> 
                <td class="text-center">
                  <?php echo $publicado; ?>
                </td>
                <td class="text-center">
                  <span class="badge badge-pill <?php echo $status[$row->adi_estado]["class"] ?>"> 
                    <?php echo $status[$row->adi_estado]["title"] ?> 
                  </span>
                </td>
                <td class="text-center">
                  <div class="dropdown">
                    <button class="btn btn-outline-primary btn-sm lh-1 btn-table dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item <?php echo $class_disabled; ?>" href="{{ route('adicional-edit',['id' => $row->id]) }}" >
                        <i class="far fa-edit"></i> Editar
                      </a>
                      <a class="dropdown-item item-delete" href="#" data-id="{{ $row->id }}" data-descripcion="{{ $row->adi_descripcion }}" data-title="<?php echo $title_estado ?>" data-estado="{{ $row->adi_estado }}" title="<?php echo $title_estado; ?>" >
                        <i class="far fa-trash-alt"></i> <?php echo $title_estado; ?>
                      </a>
                      <a class="dropdown-item <?php echo $class_disabled; ?>" href="#" data-id="{{ $row->id }}" data-descripcion="{{ $row->adi_descripcion }}" data-title="<?php echo $title ?>" data-publish="{{ $row->adi_publicar }}" title="<?php echo $title; ?>" >
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

  @include('shared.form-modal-delete', ['url' => route('actividad-delete') ])

  @include('shared.form-modal-publicar' , ['url_publish' => route('actividad-publish') ])

@endsection


@section('script')

  @include('shared.datatables')

  <script src="{{ asset('assets/js/app-form.js') }}"></script>




@endsection
