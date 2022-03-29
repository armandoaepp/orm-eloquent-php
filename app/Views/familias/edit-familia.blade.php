@php
  $sidebar = array(
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );
@endphp

  $publicar = trim($familia->publicar);

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
  Familias
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
      <a href="{{ route('admin.familias') }}" class="">
        <i class="fa fa-align-justify"></i> Familias
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Familia
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
          <i class="fa fa-align-justify"></i> Editar Familia
        </div>
        <div class="card-body">
          <div class="col-12">

            <form id="form-controls" action="{{ route('admin.familias.update',['id' => $familia->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf @method("put")
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $familia->id }}">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="cod_fam">Cod Fam: </label>
                    <input type="text" class="form-control  @error('cod_fam') is-invalid @enderror" name="cod_fam" id="cod_fam" placeholder="Cod Fam" value="{{ old('cod_fam', $familia->cod_fam ?? '') }}" >
                    @error('cod_fam')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="descripcion">Descripcion: </label>
                    <input type="text" class="form-control  @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion" placeholder="Descripcion" value="{{ old('descripcion', $familia->descripcion ?? '') }}" >
                    @error('descripcion')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="glosa">Glosa: </label>
                    <input type="text" class="form-control  @error('glosa') is-invalid @enderror" name="glosa" id="glosa" placeholder="Glosa" value="{{ old('glosa', $familia->glosa ?? '') }}" >
                    @error('glosa')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="email" class="d-block">Publicar </label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="publicar" id="si" value="S" <?php echo $si; ?> >
                      <label class="form-check-label" for="si">SI</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="publicar" id="no" value="N" <?php echo $no; ?> >
                      <label class="form-check-label" for="no">NO</label>
                    </div>
                  </div>
                </div>

                <div class="col-md-12 text-center">
                  <input type="hidden" class="form-control" name="img_bd" id="img_bd" value="{{ $familia->imagen }}">
                  @if(!empty($familia->imagen))
                  <img src="{{ url($familia->imagen) }}" class="img-fluid img-view-edit mb-2">
                  <hr>
                  @endif
                </div>
                <div class="col-12 mb-3">
                  <div class="form-group">
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="imagen">Nueva Imagen</label>
                      </div>
                      <input data-file-img="images" data-id="preview-images-id" type="file" class="form-control" name="imagen" id="imagen" placeholder="Imagen" accept="image/*">
                    </div>
                  </div>
                </div>

                <div class="col-12 mb-3">
                  <div class="preview-img" data-img-preview="preview-images-id"></div>
                </div>

              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin.familias') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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