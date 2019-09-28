
<?php
  $sidebar = array(
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );

?>


<?php
  $publicar = trim($actividad->act_publicar);

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
      <a href="{{ route('admin-actividads') }}" class="">
        <i class="fa fa-align-justify"></i> Actividads
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Actividad
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
          <i class="fa fa-align-justify"></i> Editar Actividad
        </div>
        <div class="card-body">
          <div class="col-12">

            <form id="form-controls" action="{{ route('actividad-update',['id' => $actividad->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $actividad->id }}">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="act_nombre">Nombre: </label>
                    <input type="text" class="form-control  @error('act_nombre') is-invalid @enderror" name="act_nombre" id="act_nombre" placeholder="Nombre" value="{{ old('act_nombre', $actividad->act_nombre ?? '') }}" >
                    @error('act_nombre')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="act_horas">Horas: </label>
                    <input type="number" class="form-control  @error('act_horas') is-invalid @enderror" name="act_horas" id="act_horas" placeholder="Horas" value="{{ old('act_horas', $actividad->act_horas ?? '') }}" >
                    @error('act_horas')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="act_descripcion">Descripcion: </label>
                    <textarea class="form-control ckeditor  @error('act_descripcion') is-invalid @enderror" name="act_descripcion" id="act_descripcion" placeholder="Descripcion" cols="30" rows="6">{{ $actividad->act_descripcion }}</textarea>
                    @error('act_descripcion')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="email" class="d-block">Publicar </label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="act_publicar" id="si" value="S" <?php echo $si; ?> >
                      <label class="form-check-label" for="si">SI</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="act_publicar" id="no" value="N" <?php echo $no; ?> >
                      <label class="form-check-label" for="no">NO</label>
                    </div>
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-actividads') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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