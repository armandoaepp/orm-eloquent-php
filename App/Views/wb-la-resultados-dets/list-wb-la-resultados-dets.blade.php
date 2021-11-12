@php
  $sidebar = array(
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );
@endphp

@extends('layouts.app-admin')

@section('title')
  Wb La Resultados Dets
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
      Wb La Resultados Dets
      </span>
    </li>
  </ol>
</nav>

<!-- begin:: Content -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12 mb-3">
      <a href="{{ route('admin-wb-la-resultados-dets') }}" class="btn btn-outline-secondary btn-sm btn-bar" role="button">
        <i class="fas fa-list-ul"></i>
        Listar
      </a>
      <a href="{{ route('wb-la-resultados-det-create') }}" class="btn btn-outline-secondary btn-sm btn-bar" role="button">
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
          <i class="fa fa-align-justify"></i> Lista de wb-la-resultados-dets
        </div>
        <div class="card-body">
          <!-- <div class="table-responsive"> -->

          <!--begin: Datatable -->
          <table id="dataTableLists" class="table table-sm table-hover table-bordered dt-responsive nowrap" style="width: 100%;">
            <thead>
              <tr>
                <th width="60"> Invnum </th> 
                <th> Exacod </th> 
                <th> Exades </th> 
                <th> Numitm </th> 
                <th> Numprm </th> 
                <th> Codprm </th> 
                <th> Desprm </th> 
                <th> Estprm </th> 
                <th> Obsres </th> 
                <th> Und </th> 
                <th> Tifprm </th> 
                <th> Valref </th> 
                <th> Valref2 </th> 
                <th> Ran1 </th> 
                <th> Ran2 </th> 
                <th> Resexa N </th> 
                <th> Color </th> 
                <th> Res </th> 
                <th> Res2 </th> 
                <th> Rentre </th> 
                <th> Estado Wb </th> 
                <th width="80"> Publicado </th>
                <th width="50"> Acciones </th>
              </tr>
            </thead>
            <tbody>

            @foreach ($data as $row)

            @php
            @endphp

              <tr class="<?php echo $class_estado; ?>">
                <td> {{ str_pad($row->invnum, 3, "0", STR_PAD_LEFT) }} </td> 
                <td> {{ $row->exacod }} </td> 
                <td> {{ $row->exades }} </td> 
                <td> {{ $row->numitm }} </td> 
                <td> {{ $row->numprm }} </td> 
                <td> {{ $row->codprm }} </td> 
                <td> {{ $row->desprm }} </td> 
                <td> {{ $row->estprm }} </td> 
                <td> {{ $row->obsres }} </td> 
                <td> {{ $row->und }} </td> 
                <td> {{ $row->tifprm }} </td> 
                <td> {{ $row->valref }} </td> 
                <td> {{ $row->valref2 }} </td> 
                <td> {{ $row->ran1 }} </td> 
                <td> {{ $row->ran2 }} </td> 
                <td> {{ $row->resexa_n }} </td> 
                <td> {{ $row->color }} </td> 
                <td> {{ $row->res }} </td> 
                <td> {{ $row->res2 }} </td> 
                <td> {{ $row->rentre }} </td> 
                <td> {{ $row->estado_wb }} </td> 
                <td class="text-center">
                  <span class="badge badge-pill <?php echo $status[$row->wlrd_estado]["class"] ?>"> 
                    <?php echo $status[$row->wlrd_estado]["title"] ?> 
                  </span>
                </td>
                <td class="text-center">
                  <div class="dropdown">
                    <button class="btn btn-outline-primary btn-sm lh-1 btn-table dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item <?php echo $class_disabled; ?>" href="{{ route('wb-la-resultados-det-edit',['id' => $row->invnum]) }}" >
                        <i class="far fa-edit"></i> Editar
                      </a>
                      <a class="dropdown-item item-delete" href="#" data-id="{{ $row->invnum }}" data-descripcion="{{ $row->exacod }}" data-title="<?php echo $title_estado ?>" data-estado="{{ $row->wlrd_estado }}" title="<?php echo $title_estado; ?>" >
                        <i class="far fa-trash-alt"></i> <?php echo $title_estado; ?>
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

  @include('shared.form-modal-delete', ['url' => route('wb-la-resultados-det-delete') ])

  @include('shared.form-modal-publicar' , ['url_publish' => route('wb-la-resultados-det-publish') ])

@endsection

<!-- Start:: Section script  -->
@section('script')

  @include('shared.datatables')

  <script src="{{ asset('assets/js/app-form-modals.js') }}"></script>

@endsection