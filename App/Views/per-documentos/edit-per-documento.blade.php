
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
      <a href="{{ route('admin-per-documentos') }}" class="">
        <i class="fa fa-align-justify"></i> Per Documentos
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Per Documento
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
          <i class="fa fa-align-justify"></i> Editar Per Documento
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('per-documento-update') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $per_documento->id }}">
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
                    <label for="tipo_per_documento_id">Tipo Per Documento Id: </label>
                    <select class="custom-select select2-box" name="tipo_per_documento_id" id="tipo_per_documento_id" placeholder="Tipo Per Documento Id">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pd_numero">Numero: </label>
                    <input type="text" class="form-control" name="pd_numero" id="pd_numero" placeholder="Numero" value="{{ $per_documento->pd_numero }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pd_fecha_emision">Fecha Emision: </label>
                    <input type="text" class="form-control" name="pd_fecha_emision" id="pd_fecha_emision" placeholder="Fecha Emision" value="{{ $per_documento->pd_fecha_emision }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pd_echa_caducidad">Echa Caducidad: </label>
                    <input type="text" class="form-control" name="pd_echa_caducidad" id="pd_echa_caducidad" placeholder="Echa Caducidad" value="{{ $per_documento->pd_echa_caducidad }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pd_descripcion">Descripcion: </label>
                    <input type="text" class="form-control" name="pd_descripcion" id="pd_descripcion" placeholder="Descripcion" value="{{ $per_documento->pd_descripcion }}" >
                  </div>
                </div>

                <div class="col-md-12 text-center">
                  <input type="hidden" class="form-control" name="img_bd" id="img_bd" value="{{ $per_documento->pd_imagen }}">
                  @if(!empty($per_documento->pd_imagen))
                  <img src="{{ url($per_documento->pd_imagen) }}" class="img-fluid img-view-edit mb-2">
                  <hr>
                  @endif
                </div>
                <div class="col-12 mb-3">
                  <div class="form-group">
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="pd_imagen">Nueva Imagen</label>
                      </div>
                      <input data-file-img="images" data-id="preview-images-id" type="file" class="form-control" name="pd_imagen" id="pd_imagen" placeholder="Imagen" accept="image/*">
                    </div>
                  </div>
                </div>

                <div class="col-12 mb-3">
                  <div class="preview-img" data-img-preview="preview-images-id"></div>
                </div>

              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-per-documentos') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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
