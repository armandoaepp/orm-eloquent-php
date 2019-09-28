
<?php
  $sidebar = array(
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );

?>


<?php
  $publicar = trim($adicional->adi_publicar);

  $si = "";
  $no = "";

  if ($publicar == "S") {
      $si = "checked='checked'";
  } elseif ($publicar == "N") {
      $no = "checked='checked'";
  }
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
      <a href="{{ route('admin-adicionals') }}" class="">
        <i class="fa fa-align-justify"></i> Adicionals
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Adicional
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
          <i class="fa fa-align-justify"></i> Editar Adicional
        </div>
        <div class="card-body">
          <div class="col-12">

            <form id="form-controls" action="{{ route('adicional-update',['id' => $adicional->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf @method("put")
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $adicional->id }}">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="adi_descripcion">Descripcion: </label>
                    <input type="text" class="form-control  @error('adi_descripcion') is-invalid @enderror" name="adi_descripcion" id="adi_descripcion" placeholder="Descripcion" value="{{ old('adi_descripcion', $adicional->adi_descripcion ?? '') }}" >
                    @error('adi_descripcion')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="adi_precio">Precio: </label>
                    <input type="text" class="form-control  @error('adi_precio') is-invalid @enderror" name="adi_precio" id="adi_precio" placeholder="Precio" value="{{ old('adi_precio', $adicional->adi_precio ?? '') }}" >
                    @error('adi_precio')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="email" class="d-block">Publicar </label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="adi_publicar" id="si" value="S" <?php echo $si; ?> >
                      <label class="form-check-label" for="si">SI</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="adi_publicar" id="no" value="N" <?php echo $no; ?> >
                      <label class="form-check-label" for="no">NO</label>
                    </div>
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-adicionals') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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