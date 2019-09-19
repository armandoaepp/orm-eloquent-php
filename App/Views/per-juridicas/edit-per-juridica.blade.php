
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
      <a href="{{ route('admin-per-juridicas') }}" class="">
        <i class="fa fa-align-justify"></i> Per Juridicas
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Per Juridica
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
          <i class="fa fa-align-justify"></i> Editar Per Juridica
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('per-juridica-update') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $per_juridica->id }}">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="persona_id">Persona Id: </label>
                    <select class="custom-select select2-box" name="persona_id" id="persona_id" placeholder="Persona Id">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="rubro_id">Rubro Id: </label>
                    <select class="custom-select select2-box" name="rubro_id" id="rubro_id" placeholder="Rubro Id">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pj_ruc">Ruc: </label>
                    <input type="text" class="form-control" name="pj_ruc" id="pj_ruc" placeholder="Ruc" value="{{ $per_juridica->pj_ruc }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pj_razon_social">Razon Social: </label>
                    <input type="text" class="form-control" name="pj_razon_social" id="pj_razon_social" placeholder="Razon Social" value="{{ $per_juridica->pj_razon_social }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pj_nombre_comercial">Nombre Comercial: </label>
                    <input type="text" class="form-control" name="pj_nombre_comercial" id="pj_nombre_comercial" placeholder="Nombre Comercial" value="{{ $per_juridica->pj_nombre_comercial }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pj_glosa">Glosa: </label>
                    <input type="text" class="form-control" name="pj_glosa" id="pj_glosa" placeholder="Glosa" value="{{ $per_juridica->pj_glosa }}" >
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-per-juridicas') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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
