
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
      <a href="{{ route('admin-per-telefonos') }}" class="">
        <i class="fa fa-align-justify"></i> Per Telefonos
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Per Telefono
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
          <i class="fa fa-align-justify"></i> Editar Per Telefono
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('per-telefono-update') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $per_telefono->persona_id }}">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="tipo_telefono_id">Tipo Telefono Id: </label>
                    <input type="text" class="form-control" name="tipo_telefono_id" id="tipo_telefono_id" placeholder="Tipo Telefono Id" value="{{ $per_telefono->tipo_telefono_id }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pt_jerarquia">Jerarquia: </label>
                    <input type="text" class="form-control" name="pt_jerarquia" id="pt_jerarquia" placeholder="Jerarquia" value="{{ $per_telefono->pt_jerarquia }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pt_telefono">Telefono: </label>
                    <input type="tel" class="form-control" name="pt_telefono" id="pt_telefono" placeholder="Telefono" value="{{ $per_telefono->pt_telefono }}" >
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-per-telefonos') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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
