@php
  $sidebar = array(
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );

  $publicar = trim($servicio->ser_publicar);

  $si = "";
  $no = "";

  if ($publicar == "S") {
    $si = "checked='checked'";
  } elseif ($publicar == "N") {
    $no = "checked='checked'";
  }
@endphp

@extends('layouts.app-admin')

@section('title')
  Servicios
@endsection

@section('content')

<nav class="full-content" aria-label="breadcrumb">
  <ol class="breadcrumb breadcrumb-shape breadcrumb-theme shadow-sm radius-0">
    <li class="breadcrumb-item">
      <a href="{{ route('admin') }}">
        <i class="fas fa-home"></i> Home
      </a>
    </li>

    <li class="breadcrumb-item" aria-current="page">
      <a href="{{ route('admin-servicios') }}" class="">
        <i class="fa fa-align-justify"></i> Servicios
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Servicio
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
          <i class="fa fa-align-justify"></i> Editar Servicio
        </div>
        <div class="card-body">
          <div class="col-12">

            <form id="form-controls" action="{{ route('servicio-update',['id' => $servicio->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf @method("put")
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $servicio->id }}">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="ser_descripcion">Descripcion: </label>
                    <input type="text" class="form-control  @error('ser_descripcion') is-invalid @enderror" name="ser_descripcion" id="ser_descripcion" placeholder="Descripcion" value="{{ old('ser_descripcion', $servicio->ser_descripcion ?? '') }}" >
                    @error('ser_descripcion')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="ser_icono">Icono: </label>
                    <input type="text" class="form-control  @error('ser_icono') is-invalid @enderror" name="ser_icono" id="ser_icono" placeholder="Icono" value="{{ old('ser_icono', $servicio->ser_icono ?? '') }}" >
                    @error('ser_icono')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="ser_incluye">Incluye: </label>
                    <input type="text" class="form-control  @error('ser_incluye') is-invalid @enderror" name="ser_incluye" id="ser_incluye" placeholder="Incluye" value="{{ old('ser_incluye', $servicio->ser_incluye ?? '') }}" >
                    @error('ser_incluye')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="ser_no_incluye">No Incluye: </label>
                    <input type="text" class="form-control  @error('ser_no_incluye') is-invalid @enderror" name="ser_no_incluye" id="ser_no_incluye" placeholder="No Incluye" value="{{ old('ser_no_incluye', $servicio->ser_no_incluye ?? '') }}" >
                    @error('ser_no_incluye')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="email" class="d-block">Publicar </label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="ser_publicar" id="si" value="S" <?php echo $si; ?> >
                      <label class="form-check-label" for="si">SI</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="ser_publicar" id="no" value="N" <?php echo $no; ?> >
                      <label class="form-check-label" for="no">NO</label>
                    </div>
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-servicios') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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

  @include('shared.jquery-validation')

@endsection