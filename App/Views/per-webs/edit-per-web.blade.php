
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
      <a href="{{ route('admin-per-webs') }}" class="">
        <i class="fa fa-align-justify"></i> Per Webs
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Per Web
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
          <i class="fa fa-align-justify"></i> Editar Per Web
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('per-web-update') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $per_web->id }}">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="persona_id">Persona Id: </label>
                    <input type="text" class="form-control" name="persona_id" id="persona_id" placeholder="Persona Id" value="{{ $per_web->persona_id }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="tipo_web_id">Tipo Web Id: </label>
                    <select class="custom-select select2-box" name="tipo_web_id" id="tipo_web_id" placeholder="Tipo Web Id">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-per-webs') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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
