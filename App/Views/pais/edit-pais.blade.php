@php
  $sidebar = array(
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );

@extends('layouts.app-admin')

@section('title')
  Pais
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
      <a href="{{ route('admin-pais') }}" class="">
        <i class="fa fa-align-justify"></i> Pais
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Pais
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
          <i class="fa fa-align-justify"></i> Editar Pais
        </div>
        <div class="card-body">
          <div class="col-12">

            <form id="form-controls" action="{{ route('pais-update',['id' => $pais->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf @method("put")
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $pais->id }}">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="code">Code: </label>
                    <input type="text" class="form-control  @error('code') is-invalid @enderror" name="code" id="code" placeholder="Code" value="{{ old('code', $pais->code ?? '') }}" >
                    @error('code')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="nombre">Nombre: </label>
                    <input type="text" class="form-control  @error('nombre') is-invalid @enderror" name="nombre" id="nombre" placeholder="Nombre" value="{{ old('nombre', $pais->nombre ?? '') }}" >
                    @error('nombre')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-pais') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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