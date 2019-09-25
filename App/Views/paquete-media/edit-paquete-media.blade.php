
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

    <li class="breadcrumb-item" aria-current="page">
      <a href="{{ route('admin-paquete-media') }}" class="">
        <i class="fa fa-align-justify"></i> Paquete Media
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Paquete Media
      </span>
    </li>
  </ol>
</nav>

<!-- begin:: Content -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header bg-white">
          <i class="fa fa-align-justify"></i> Editar Paquete Media
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('paquete-media-update') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $paquete_media->id }}">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="paquete_id">Paquete Id: </label>
                    <select class="custom-select select2-box" name="paquete_id" id="paquete_id" placeholder="Paquete Id">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="tipo_media_id">Tipo Media Id: </label>
                    <select class="custom-select select2-box" name="tipo_media_id" id="tipo_media_id" placeholder="Tipo Media Id">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pm_path_file">Path File: </label>
                    <input type="text" class="form-control" name="pm_path_file" id="pm_path_file" placeholder="Path File" value="{{ $paquete_media->pm_path_file }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pm_jerarquia">Jerarquia: </label>
                    <input type="number" class="form-control" name="pm_jerarquia" id="pm_jerarquia" placeholder="Jerarquia" value="{{ $paquete_media->pm_jerarquia }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pm_descripcion">Descripcion: </label>
                    <input type="text" class="form-control" name="pm_descripcion" id="pm_descripcion" placeholder="Descripcion" value="{{ $paquete_media->pm_descripcion }}" >
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-paquete-media') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>

              </div>

            </form>
          </div>

        </div>
      </div>
    </div>

  </div>
</div>

<!-- end:: Content -->


@endsection


@section('script')


@endsection
