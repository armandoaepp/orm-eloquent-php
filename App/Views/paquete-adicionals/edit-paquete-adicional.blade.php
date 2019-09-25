
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
      <a href="{{ route('admin-paquete-adicionals') }}" class="">
        <i class="fa fa-align-justify"></i> Paquete Adicionals
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Paquete Adicional
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
          <i class="fa fa-align-justify"></i> Editar Paquete Adicional
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('paquete-adicional-update') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $paquete_adicional->id }}">
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
                    <label for="adicional_id">Adicional Id: </label>
                    <select class="custom-select select2-box" name="adicional_id" id="adicional_id" placeholder="Adicional Id">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pa_precio">Precio: </label>
                    <input type="number" class="form-control" name="pa_precio" id="pa_precio" placeholder="Precio" value="{{ $paquete_adicional->pa_precio }}" >
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-paquete-adicionals') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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
