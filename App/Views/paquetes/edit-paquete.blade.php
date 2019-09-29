@php
  $sidebar = array(
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );

  $publicar = trim($paquete->publicar);

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
  Paquetes
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
      <a href="{{ route('admin-paquetes') }}" class="">
        <i class="fa fa-align-justify"></i> Paquetes
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Paquete
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
          <i class="fa fa-align-justify"></i> Editar Paquete
        </div>
        <div class="card-body">
          <div class="col-12">

            <form id="form-controls" action="{{ route('paquete-update',['id' => $paquete->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf @method("put")
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $paquete->id }}">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="ubigeo_id">Ubigeo Id: </label>
                    <input type="text" class="form-control  @error('ubigeo_id') is-invalid @enderror" name="ubigeo_id" id="ubigeo_id" placeholder="Ubigeo Id" value="{{ old('ubigeo_id', $paquete->ubigeo_id ?? '') }}" >
                    @error('ubigeo_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="nombre">Nombre: </label>
                    <input type="text" class="form-control  @error('nombre') is-invalid @enderror" name="nombre" id="nombre" placeholder="Nombre" value="{{ old('nombre', $paquete->nombre ?? '') }}" >
                    @error('nombre')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="descripcion">Descripcion: </label>
                    <input type="text" class="form-control  @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion" placeholder="Descripcion" value="{{ old('descripcion', $paquete->descripcion ?? '') }}" >
                    @error('descripcion')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="recomendacion">Recomendacion: </label>
                    <input type="text" class="form-control  @error('recomendacion') is-invalid @enderror" name="recomendacion" id="recomendacion" placeholder="Recomendacion" value="{{ old('recomendacion', $paquete->recomendacion ?? '') }}" >
                    @error('recomendacion')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="num_dias">Num Dias: </label>
                    <input type="text" class="form-control  @error('num_dias') is-invalid @enderror" name="num_dias" id="num_dias" placeholder="Num Dias" value="{{ old('num_dias', $paquete->num_dias ?? '') }}" >
                    @error('num_dias')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="num_noches">Num Noches: </label>
                    <input type="text" class="form-control  @error('num_noches') is-invalid @enderror" name="num_noches" id="num_noches" placeholder="Num Noches" value="{{ old('num_noches', $paquete->num_noches ?? '') }}" >
                    @error('num_noches')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="precio">Precio: </label>
                    <input type="text" class="form-control  @error('precio') is-invalid @enderror" name="precio" id="precio" placeholder="Precio" value="{{ old('precio', $paquete->precio ?? '') }}" >
                    @error('precio')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="descuento">Descuento: </label>
                    <input type="text" class="form-control  @error('descuento') is-invalid @enderror" name="descuento" id="descuento" placeholder="Descuento" value="{{ old('descuento', $paquete->descuento ?? '') }}" >
                    @error('descuento')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="precio_descuento">Precio Descuento: </label>
                    <input type="text" class="form-control  @error('precio_descuento') is-invalid @enderror" name="precio_descuento" id="precio_descuento" placeholder="Precio Descuento" value="{{ old('precio_descuento', $paquete->precio_descuento ?? '') }}" >
                    @error('precio_descuento')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="fecha_ini_promo">Fecha Ini Promo: </label>
                    <input type="text" class="form-control  @error('fecha_ini_promo') is-invalid @enderror" name="fecha_ini_promo" id="fecha_ini_promo" placeholder="Fecha Ini Promo" value="{{ old('fecha_ini_promo', $paquete->fecha_ini_promo ?? '') }}" >
                    @error('fecha_ini_promo')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="fecha_fin_promo">Fecha Fin Promo: </label>
                    <input type="text" class="form-control  @error('fecha_fin_promo') is-invalid @enderror" name="fecha_fin_promo" id="fecha_fin_promo" placeholder="Fecha Fin Promo" value="{{ old('fecha_fin_promo', $paquete->fecha_fin_promo ?? '') }}" >
                    @error('fecha_fin_promo')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="num_visitas">Num Visitas: </label>
                    <input type="text" class="form-control  @error('num_visitas') is-invalid @enderror" name="num_visitas" id="num_visitas" placeholder="Num Visitas" value="{{ old('num_visitas', $paquete->num_visitas ?? '') }}" >
                    @error('num_visitas')
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


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-paquetes') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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