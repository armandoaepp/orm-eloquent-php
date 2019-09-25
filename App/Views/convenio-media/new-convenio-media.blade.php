
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
      <a href="{{ route('admin-convenio-media') }}" class="">
        <i class="fa fa-align-justify"></i> Convenio Media
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Nuevo Convenio Media
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
          <i class="fa fa-align-justify"></i> Nuevo Convenio Media
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('convenio-media-store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="convenio_id">Convenio Id: </label>
                    <select class="custom-select select2-box" name="convenio_id" id="convenio_id" placeholder="Convenio Id">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="cm_path_file">Path File: </label>
                    <input type="text" class="form-control" name="cm_path_file" id="cm_path_file" placeholder="Path File">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="cm_jerarquia">Jerarquia: </label>
                    <input type="number" class="form-control" name="cm_jerarquia" id="cm_jerarquia" placeholder="Jerarquia">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="cm_descripcion">Descripcion: </label>
                    <input type="text" class="form-control" name="cm_descripcion" id="cm_descripcion" placeholder="Descripcion">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="con_estado">Con Estado: </label>
                    <input type="text" class="form-control" name="con_estado" id="con_estado" placeholder="Con Estado">
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-convenio-media') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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
