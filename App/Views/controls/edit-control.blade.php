
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
      <a href="{{ route('admin-controls') }}" class="">
        <i class="fa fa-align-justify"></i> Controls
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Control
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
          <i class="fa fa-align-justify"></i> Editar Control
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('control-update') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $control->id }}">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="control_padre_id">Control Padre Id: </label>
                    <select class="custom-select select2-box" name="control_padre_id" id="control_padre_id" placeholder="Control Padre Id">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="tipo_control_id">Tipo Control Id: </label>
                    <input type="text" class="form-control" name="tipo_control_id" id="tipo_control_id" placeholder="Tipo Control Id" value="{{ $control->tipo_control_id }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="jerarquia">Jerarquia: </label>
                    <input type="text" class="form-control" name="jerarquia" id="jerarquia" placeholder="Jerarquia" value="{{ $control->jerarquia }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="nombre">Nombre: </label>
                    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" value="{{ $control->nombre }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="valor">Valor: </label>
                    <input type="text" class="form-control" name="valor" id="valor" placeholder="Valor" value="{{ $control->valor }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="descripcion">Descripcion: </label>
                    <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Descripcion" value="{{ $control->descripcion }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="glosa">Glosa: </label>
                    <input type="text" class="form-control" name="glosa" id="glosa" placeholder="Glosa" value="{{ $control->glosa }}" >
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-controls') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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
