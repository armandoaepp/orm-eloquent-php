@php
  $sidebar = array(
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );
@endphp

@extends('layouts.app-admin')

@section('title')
  Rols
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
      <a href="{{ route('admin-rols') }}" class="">
        <i class="fa fa-align-justify"></i> Rols
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Nuevo Rol
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
          <i class="fa fa-align-justify"></i> Nuevo Rol
        </div>
        <div class="card-body">
          <div class="col-12">

            <form id="form-controls" action="{{  route('rol-store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="per_id_padre">Per Id Padre: </label>
                    <input type="text" class="form-control @error('per_id_padre') is-invalid @enderror" name="per_id_padre" id="per_id_padre" value="{{ old('per_id_padre') }}" required placeholder="Per Id Padre">
                    @error('per_id_padre')
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


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-rols') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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