
<?php
  $sidebar = array(
    "sidebar_class" => "",
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );

?>

@extends('layouts.app-admin')

@section('content')

<nav class="full-content" aria-label="breadcrumb">
  <ol class="breadcrumb breadcrumb-shape shadow-sm radius-0">
    <li class="breadcrumb-item">
      <a href="{{ route('admin') }}">
        <i class="fas fa-home"></i> Home
      </a>
    </li>

    <li class="breadcrumb-item" aria-current="page">
      <a href="{{ route('admin-contactos') }}" class="">
      Contactos
      </a>
    </li>

    <li class="breadcrumb-item active bg-info text-white" aria-current="page">
      <span>
      Editar Contacto
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
          <i class="fa fa-align-justify"></i> Editar Contacto
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('contacto-update') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $data->contacto_id }}">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="per_id_padre">Per Id Padre: </label>
                    <input type="text" class="form-control" name="per_id_padre" id="per_id_padre" placeholder="Per Id Padre" value="{{ $data->per_id_padre }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="nombre">Nombre: </label>
                    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" value="{{ $data->nombre }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="apellidos">Apellidos: </label>
                    <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Apellidos" value="{{ $data->apellidos }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="email">Email: </label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ $data->email }}" >
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-contactos') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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
