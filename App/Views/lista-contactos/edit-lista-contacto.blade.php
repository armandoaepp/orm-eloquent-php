
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
      <a href="{{ route('admin-lista contactos') }}" class="">
      Lista Contactos
      </a>
    </li>

    <li class="breadcrumb-item active bg-info text-white" aria-current="page">
      <span>
      Editar Lista Contacto
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
          <i class="fa fa-align-justify"></i> Editar Lista Contacto
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('lista contacto-update') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $data->lista_contacto_id }}">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="contacto_id">Contacto Id: </label>
                    <input type="text" class="form-control" name="contacto_id" id="contacto_id" placeholder="Contacto Id" value="{{ $data->contacto_id }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="lista_id">Lista Id: </label>
                    <input type="text" class="form-control" name="lista_id" id="lista_id" placeholder="Lista Id" value="{{ $data->lista_id }}" >
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-lista contactos') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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
