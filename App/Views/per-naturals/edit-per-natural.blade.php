
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
      <a href="{{ route('admin-per-naturals') }}" class="">
        <i class="fa fa-align-justify"></i> Per Naturals
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Per Natural
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
          <i class="fa fa-align-justify"></i> Editar Per Natural
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('per-natural-update') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $per_natural->id }}">
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
                    <label for="pn_dni">Dni: </label>
                    <input type="number" class="form-control" name="pn_dni" id="pn_dni" placeholder="Dni" value="{{ $per_natural->pn_dni }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pn_ruc">Ruc: </label>
                    <input type="number" class="form-control" name="pn_ruc" id="pn_ruc" placeholder="Ruc" value="{{ $per_natural->pn_ruc }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pn_apellidos">Apellidos: </label>
                    <input type="text" class="form-control" name="pn_apellidos" id="pn_apellidos" placeholder="Apellidos" value="{{ $per_natural->pn_apellidos }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pn_nombres">Nombres: </label>
                    <input type="text" class="form-control" name="pn_nombres" id="pn_nombres" placeholder="Nombres" value="{{ $per_natural->pn_nombres }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="sexo_id">Sexo Id: </label>
                    <select class="custom-select select2-box" name="sexo_id" id="sexo_id" placeholder="Sexo Id">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="estado_civil_id">Estado Civil Id: </label>
                    <select class="custom-select select2-box" name="estado_civil_id" id="estado_civil_id" placeholder="Estado Civil Id">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-per-naturals') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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
