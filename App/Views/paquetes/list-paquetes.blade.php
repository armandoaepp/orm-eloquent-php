@php
  $sidebar = array(
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );
@endphp

@extends('layouts.app-admin')

@section('title')
  Paquetes
@endsection

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
      Paquetes
      </span>
    </li>
  </ol>
</nav>

<!-- begin:: Content -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12 mb-3">
      <a href="{{ route('admin-paquetes') }}" class="btn btn-outline-secondary btn-sm btn-bar" role="button">
        <i class="fas fa-list-ul"></i>
        Listar
      </a>
      <a href="{{ route('paquete-create') }}" class="btn btn-outline-secondary btn-sm btn-bar" role="button">
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
          <i class="fa fa-align-justify"></i> Lista de paquetes
        </div>
        <div class="card-body">
          <!-- <div class="table-responsive"> -->

          <!--begin: Datatable -->
          <table id="dataTableLists" class="table table-sm table-hover table-bordered dt-responsive nowrap" style="width: 100%;">
            <thead>
              <tr>
                <th width="60"> Id </th> 
                <th> Ubigeo Id </th> 
                <th> Nombre </th> 
                <th> Descripcion </th> 
                <th> Recomendacion </th> 
                <th> Num Dias </th> 
                <th> Num Noches </th> 
                <th> Precio </th> 
                <th> Descuento </th> 
                <th> Precio Descuento </th> 
                <th> Fecha Ini Promo </th> 
                <th> Fecha Fin Promo </th> 
                <th> Num Visitas </th> 
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

              if(!empty($row->publicar)){
                if($row->publicar == "S"){
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

              if ($row->estado == 0) {
                $title_estado = "Recuperar";
                $class_estado = "row-disabled";
                $class_disabled = "disabled";
              } else {
                $title_estado = "Eliminar";
              }


            ?>

              <tr class="<?php echo $class_estado; ?>">
                <td> {{ str_pad($row->id, 3, "0", STR_PAD_LEFT) }} </td> 
                <td> {{ $row->ubigeo_id }} </td> 
                <td> {{ $row->nombre }} </td> 
                <td> {{ $row->descripcion }} </td> 
                <td> {{ $row->recomendacion }} </td> 
                <td> {{ $row->num_dias }} </td> 
                <td> {{ $row->num_noches }} </td> 
                <td> {{ $row->precio }} </td> 
                <td> {{ $row->descuento }} </td> 
                <td> {{ $row->precio_descuento }} </td> 
                <td> {{ $row->fecha_ini_promo }} </td> 
                <td> {{ $row->fecha_fin_promo }} </td> 
                <td> {{ $row->num_visitas }} </td> 
                <td class="text-center">
                  <?php echo $publicado; ?>
                </td>
                <td class="text-center">
                  <span class="badge badge-pill <?php echo $status[$row->estado]["class"] ?>"> 
                    <?php echo $status[$row->estado]["title"] ?> 
                  </span>
                </td>
                <td class="text-center">
                  <div class="dropdown">
                    <button class="btn btn-outline-primary btn-sm lh-1 btn-table dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item <?php echo $class_disabled; ?>" href="{{ route('paquete-edit',['id' => $row->id]) }}" >
                        <i class="far fa-edit"></i> Editar
                      </a>
                      <a class="dropdown-item item-delete" href="#" data-id="{{ $row->id }}" data-descripcion="{{ $row->ubigeo_id }}" data-title="<?php echo $title_estado ?>" data-estado="{{ $row->estado }}" title="<?php echo $title_estado; ?>" >
                        <i class="far fa-trash-alt"></i> <?php echo $title_estado; ?>
                      </a>
                      <a class="dropdown-item item-publish <?php echo $class_disabled; ?>" href="#" data-id="{{ $row->id }}" data-descripcion="{{ $row->ubigeo_id }}" data-title="<?php echo $title ?>" data-publish="{{ $row->publicar }}" title="<?php echo $title; ?>" >
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

<!-- Start:: Section modal  -->
@section('modal')

  @include('shared.form-modal-delete', ['url' => route('paquete-delete') ])

  @include('shared.form-modal-publicar' , ['url_publish' => route('paquete-publish') ])

@endsection

<!-- Start:: Section script  -->
@section('script')

  @include('shared.datatables')

  <script src="{{ asset('assets/js/app-form.js') }}"></script>

@endsection