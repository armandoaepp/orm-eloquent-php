
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
      <a href="{{ route('admin-ubigeos') }}" class="">
        <i class="fa fa-align-justify"></i> Ubigeos
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Ubigeo
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
          <i class="fa fa-align-justify"></i> Editar Ubigeo
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('ubigeo-update') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $ubigeo->id }}">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pais_id">Pais Id: </label>
                    <select class="custom-select select2-box" name="pais_id" id="pais_id" placeholder="Pais Id">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="ubigeo_id_padre">Ubigeo Id Padre: </label>
                    <select class="custom-select select2-box" name="ubigeo_id_padre" id="ubigeo_id_padre" placeholder="Ubigeo Id Padre">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="ubi_codigo">Codigo: </label>
                    <input type="text" class="form-control" name="ubi_codigo" id="ubi_codigo" placeholder="Codigo" value="{{ $ubigeo->ubi_codigo }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="ubi_ubigeo">Ubigeo: </label>
                    <input type="text" class="form-control" name="ubi_ubigeo" id="ubi_ubigeo" placeholder="Ubigeo" value="{{ $ubigeo->ubi_ubigeo }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="ubi_descripcion">Descripcion: </label>
                    <input type="text" class="form-control" name="ubi_descripcion" id="ubi_descripcion" placeholder="Descripcion" value="{{ $ubigeo->ubi_descripcion }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="tipo_ubigeo_id">Tipo Ubigeo Id: </label>
                    <input type="text" class="form-control" name="tipo_ubigeo_id" id="tipo_ubigeo_id" placeholder="Tipo Ubigeo Id" value="{{ $ubigeo->tipo_ubigeo_id }}" >
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-ubigeos') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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
