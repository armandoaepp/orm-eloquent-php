
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
      <a href="{{ route('admin-personas') }}" class="">
        <i class="fa fa-align-justify"></i> Personas
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Persona
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
          <i class="fa fa-align-justify"></i> Editar Persona
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('persona-update') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $persona->id }}">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="per_id_padre">Id Padre: </label>
                    <input type="text" class="form-control" name="per_id_padre" id="per_id_padre" placeholder="Id Padre" value="{{ $persona->per_id_padre }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="per_nombre">Nombre: </label>
                    <input type="text" class="form-control" name="per_nombre" id="per_nombre" placeholder="Nombre" value="{{ $persona->per_nombre }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="per_apellidos">Apellidos: </label>
                    <input type="text" class="form-control" name="per_apellidos" id="per_apellidos" placeholder="Apellidos" value="{{ $persona->per_apellidos }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="per_fecha_nac">Fecha Nac: </label>
                    <input type="date" class="form-control" name="per_fecha_nac" id="per_fecha_nac" placeholder="Fecha Nac" value="{{ $persona->per_fecha_nac }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="per_tipo">Tipo: </label>
                    <input type="text" class="form-control" name="per_tipo" id="per_tipo" placeholder="Tipo" value="{{ $persona->per_tipo }}" >
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-personas') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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
