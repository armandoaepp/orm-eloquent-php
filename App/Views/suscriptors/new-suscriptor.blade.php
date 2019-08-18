
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
  <ol class="breadcrumb breadcrumb-shape shadow-sm radius-0">
    <li class="breadcrumb-item">
      <a href="{{ route('admin') }}">
        <i class="fas fa-home"></i> Home
      </a>
    </li>

    <li class="breadcrumb-item" aria-current="page">
      <a href="{{ route('admin-suscriptors') }}" class="">
      Suscriptors
      </a>
    </li>

    <li class="breadcrumb-item active bg-info text-white" aria-current="page">
      <span>
      Nuevo Suscriptor
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
          <i class="fa fa-align-justify"></i> Nuevo Suscriptor
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('suscriptor-save') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="nombre">Nombre: </label>
                    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="email">Email: </label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="telefono">Telefono: </label>
                    <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Telefono">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="empresa">Empresa: </label>
                    <input type="text" class="form-control" name="empresa" id="empresa" placeholder="Empresa">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="mensaje">Mensaje: </label>
                    <input type="text" class="form-control" name="mensaje" id="mensaje" placeholder="Mensaje">
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-suscriptors') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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
