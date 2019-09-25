
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
      <a href="{{ route('admin-per-doc-identidads') }}" class="">
        <i class="fa fa-align-justify"></i> Per Doc Identidads
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Per Doc Identidad
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
          <i class="fa fa-align-justify"></i> Editar Per Doc Identidad
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('per-doc-identidad-update') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $per_doc_identidad->id }}">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="persona_id">Persona Id: </label>
                    <select class="custom-select select2-box" name="persona_id" id="persona_id" placeholder="Persona Id">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="tipo_per_doc_identidad_id">Tipo Per Doc Identidad Id: </label>
                    <select class="custom-select select2-box" name="tipo_per_doc_identidad_id" id="tipo_per_doc_identidad_id" placeholder="Tipo Per Doc Identidad Id">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pdi_jerarquia">Jerarquia: </label>
                    <input type="text" class="form-control" name="pdi_jerarquia" id="pdi_jerarquia" placeholder="Jerarquia" value="{{ $per_doc_identidad->pdi_jerarquia }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pdi_numero">Numero: </label>
                    <input type="text" class="form-control" name="pdi_numero" id="pdi_numero" placeholder="Numero" value="{{ $per_doc_identidad->pdi_numero }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pdi_fecha_emision">Fecha Emision: </label>
                    <input type="text" class="form-control" name="pdi_fecha_emision" id="pdi_fecha_emision" placeholder="Fecha Emision" value="{{ $per_doc_identidad->pdi_fecha_emision }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pdi_fecha_caducidad">Fecha Caducidad: </label>
                    <input type="text" class="form-control" name="pdi_fecha_caducidad" id="pdi_fecha_caducidad" placeholder="Fecha Caducidad" value="{{ $per_doc_identidad->pdi_fecha_caducidad }}" >
                  </div>
                </div>

                <div class="col-md-12 text-center">
                  <input type="hidden" class="form-control" name="img_bd" id="img_bd" value="{{ $per_doc_identidad->pdi_imagen }}">
                  @if(!empty($per_doc_identidad->pdi_imagen))
                  <img src="{{ url($per_doc_identidad->pdi_imagen) }}" class="img-fluid img-view-edit mb-2">
                  <hr>
                  @endif
                </div>
                <div class="col-12 mb-3">
                  <div class="form-group">
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="pdi_imagen">Nueva Imagen</label>
                      </div>
                      <input data-file-img="images" data-id="preview-images-id" type="file" class="form-control" name="pdi_imagen" id="pdi_imagen" placeholder="Imagen" accept="image/*">
                    </div>
                  </div>
                </div>

                <div class="col-12 mb-3">
                  <div class="preview-img" data-img-preview="preview-images-id"></div>
                </div>

              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-per-doc-identidads') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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
