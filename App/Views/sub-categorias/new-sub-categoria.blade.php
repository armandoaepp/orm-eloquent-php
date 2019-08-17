
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
  <ol class="breadcrumb breadcrumb-shape shadow-sm radius-0">
    <li class="breadcrumb-item">
      <a href="{{ route('admin') }}">
        <i class="fas fa-home"></i> Home
      </a>
    </li>

    <li class="breadcrumb-item" aria-current="page">
      <a href="{{ route('admin-sub categorias') }}" class="">
      Sub Categorias
      </a>
    </li>

    <li class="breadcrumb-item active bg-info text-white" aria-current="page">
      <span>
      Nuevo Sub Categoria
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
          <i class="fa fa-align-justify"></i> Nuevo Sub Categoria
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('sub categoria-save') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="categoria_id">Categoria Id: </label>
                    <input type="text" class="form-control" name="categoria_id" id="categoria_id" placeholder="Categoria Id">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="sc_descripcion">Sc Descripcion: </label>
                    <input type="text" class="form-control" name="sc_descripcion" id="sc_descripcion" placeholder="Sc Descripcion">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="sc_imagen">Sc Imagen: </label>
                    <input type="text" class="form-control" name="sc_imagen" id="sc_imagen" placeholder="Sc Imagen">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="sc_estado">Sc Estado: </label>
                    <input type="text" class="form-control" name="sc_estado" id="sc_estado" placeholder="Sc Estado">
                  </div>
                </div>




              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-sub categorias') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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
