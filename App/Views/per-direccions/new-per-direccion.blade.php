
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
      <a href="{{ route('admin-per-direccions') }}" class="">
        <i class="fa fa-align-justify"></i> Per Direccions
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Nuevo Per Direccion
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
          <i class="fa fa-align-justify"></i> Nuevo Per Direccion
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('per-direccion-store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="persona_id">Persona Id: </label>
                    <input type="text" class="form-control" name="persona_id" id="persona_id" placeholder="Persona Id">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="tipo_direccion_id">Tipo Direccion Id: </label>
                    <input type="text" class="form-control" name="tipo_direccion_id" id="tipo_direccion_id" placeholder="Tipo Direccion Id">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="ubigeo_id">Ubigeo Id: </label>
                    <input type="text" class="form-control" name="ubigeo_id" id="ubigeo_id" placeholder="Ubigeo Id">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pd_jerarquia">Jerarquia: </label>
                    <input type="text" class="form-control" name="pd_jerarquia" id="pd_jerarquia" placeholder="Jerarquia">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pd_direccion">Direccion: </label>
                    <input type="text" class="form-control" name="pd_direccion" id="pd_direccion" placeholder="Direccion">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pd_referencia">Referencia: </label>
                    <input type="text" class="form-control" name="pd_referencia" id="pd_referencia" placeholder="Referencia">
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-per-direccions') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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
