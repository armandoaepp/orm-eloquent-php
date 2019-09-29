@php
  $sidebar = array(
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );
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
      Nuevo Paquete
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
          <i class="fa fa-align-justify"></i> Nuevo Paquete
        </div>
        <div class="card-body">
          <div class="col-12">

            <form id="form-controls" action="{{  route('paquete-store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="ubigeo_id">Ubigeo Id: </label>
                    <input type="text" class="form-control @error('ubigeo_id') is-invalid @enderror" name="ubigeo_id" id="ubigeo_id" value="{{ old('ubigeo_id') }}" required placeholder="Ubigeo Id">
                    @error('ubigeo_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="nombre">Nombre: </label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" id="nombre" value="{{ old('nombre') }}" required placeholder="Nombre">
                    @error('nombre')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="descripcion">Descripcion: </label>
                    <input type="text" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion" value="{{ old('descripcion') }}" required placeholder="Descripcion">
                    @error('descripcion')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="recomendacion">Recomendacion: </label>
                    <input type="text" class="form-control @error('recomendacion') is-invalid @enderror" name="recomendacion" id="recomendacion" value="{{ old('recomendacion') }}" required placeholder="Recomendacion">
                    @error('recomendacion')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="num_dias">Num Dias: </label>
                    <input type="text" class="form-control @error('num_dias') is-invalid @enderror" name="num_dias" id="num_dias" value="{{ old('num_dias') }}" required placeholder="Num Dias">
                    @error('num_dias')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="num_noches">Num Noches: </label>
                    <input type="text" class="form-control @error('num_noches') is-invalid @enderror" name="num_noches" id="num_noches" value="{{ old('num_noches') }}" required placeholder="Num Noches">
                    @error('num_noches')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="precio">Precio: </label>
                    <input type="text" class="form-control @error('precio') is-invalid @enderror" name="precio" id="precio" value="{{ old('precio') }}" required placeholder="Precio">
                    @error('precio')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="descuento">Descuento: </label>
                    <input type="text" class="form-control @error('descuento') is-invalid @enderror" name="descuento" id="descuento" value="{{ old('descuento') }}" required placeholder="Descuento">
                    @error('descuento')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="precio_descuento">Precio Descuento: </label>
                    <input type="text" class="form-control @error('precio_descuento') is-invalid @enderror" name="precio_descuento" id="precio_descuento" value="{{ old('precio_descuento') }}" required placeholder="Precio Descuento">
                    @error('precio_descuento')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="fecha_ini_promo">Fecha Ini Promo: </label>
                    <input type="text" class="form-control @error('fecha_ini_promo') is-invalid @enderror" name="fecha_ini_promo" id="fecha_ini_promo" value="{{ old('fecha_ini_promo') }}"  placeholder="Fecha Ini Promo">
                    @error('fecha_ini_promo')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="fecha_fin_promo">Fecha Fin Promo: </label>
                    <input type="text" class="form-control @error('fecha_fin_promo') is-invalid @enderror" name="fecha_fin_promo" id="fecha_fin_promo" value="{{ old('fecha_fin_promo') }}"  placeholder="Fecha Fin Promo">
                    @error('fecha_fin_promo')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="num_visitas">Num Visitas: </label>
                    <input type="text" class="form-control @error('num_visitas') is-invalid @enderror" name="num_visitas" id="num_visitas" value="{{ old('num_visitas') }}" required placeholder="Num Visitas">
                    @error('num_visitas')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="email" class="d-block">Publicar </label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="publicar" id="si" value="S" checked="checked">
                      <label class="form-check-label" for="si">SI</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="publicar" id="no" value="N">
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