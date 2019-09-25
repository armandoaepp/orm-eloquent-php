
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
      <a href="{{ route('admin-itinerarios') }}" class="">
        <i class="fa fa-align-justify"></i> Itinerarios
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Nuevo Itinerario
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
          <i class="fa fa-align-justify"></i> Nuevo Itinerario
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('itinerario-store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="paquete_id">Paquete Id: </label>
                    <input type="text" class="form-control" name="paquete_id" id="paquete_id" placeholder="Paquete Id">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="iti_dia">Dia: </label>
                    <input type="number" class="form-control" name="iti_dia" id="iti_dia" placeholder="Dia">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="iti_titulo">Titulo: </label>
                    <input type="text" class="form-control" name="iti_titulo" id="iti_titulo" placeholder="Titulo">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="iti_descripcion">Descripcion: </label>
                    <textarea class="form-control ckeditor" name="iti_descripcion" id="iti_descripcion" placeholder="Descripcion" cols="30" rows="6"></textarea>
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-itinerarios') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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
