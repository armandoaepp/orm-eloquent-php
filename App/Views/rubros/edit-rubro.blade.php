
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
      <a href="{{ route('admin-rubros') }}" class="">
        <i class="fa fa-align-justify"></i> Rubros
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Rubro
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
          <i class="fa fa-align-justify"></i> Editar Rubro
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('rubro-update') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $rubro->id }}">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="rub_descripcion">Descripcion: </label>
                    <input type="text" class="form-control" name="rub_descripcion" id="rub_descripcion" placeholder="Descripcion" value="{{ $rubro->rub_descripcion }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="rub_codigo">Codigo: </label>
                    <input type="text" class="form-control" name="rub_codigo" id="rub_codigo" placeholder="Codigo" value="{{ $rubro->rub_codigo }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="rub_glosa">Glosa: </label>
                    <input type="text" class="form-control" name="rub_glosa" id="rub_glosa" placeholder="Glosa" value="{{ $rubro->rub_glosa }}" >
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-rubros') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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
