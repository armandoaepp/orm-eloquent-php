@php
  $sidebar = array(
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );

@extends('layouts.app-admin')

@section('title')
  Regions
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
      <a href="{{ route('admin-regions') }}" class="">
        <i class="fa fa-align-justify"></i> Regions
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Region
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
          <i class="fa fa-align-justify"></i> Editar Region
        </div>
        <div class="card-body">
          <div class="col-12">

            <form id="form-controls" action="{{ route('region-update',['id' => $region->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf @method("put")
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $region->id }}">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="reg_nombre">Nombre: </label>
                    <input type="text" class="form-control  @error('reg_nombre') is-invalid @enderror" name="reg_nombre" id="reg_nombre" placeholder="Nombre" value="{{ old('reg_nombre', $region->reg_nombre ?? '') }}" >
                    @error('reg_nombre')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-regions') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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