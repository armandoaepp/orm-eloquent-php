
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
      <a href="{{ route('admin-productos') }}" class="">
      Productos
      </a>
    </li>

    <li class="breadcrumb-item active bg-info text-white" aria-current="page">
      <span>
      Nuevo Producto
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
          <i class="fa fa-align-justify"></i> Nuevo Producto
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('producto-save') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="sub_categoria_id">Sub Categoria Id: </label>
                    <input type="text" class="form-control" name="sub_categoria_id" id="sub_categoria_id" placeholder="Sub Categoria Id">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="codigo">Codigo: </label>
                    <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Codigo">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="descripcion">Descripcion: </label>
                    <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Descripcion">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="glosa">Glosa: </label>
                    <input type="text" class="form-control" name="glosa" id="glosa" placeholder="Glosa">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="precio">Precio: </label>
                    <input type="text" class="form-control" name="precio" id="precio" placeholder="Precio">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="descuento">Descuento: </label>
                    <input type="text" class="form-control" name="descuento" id="descuento" placeholder="Descuento">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="precio_descuento">Precio Descuento: </label>
                    <input type="text" class="form-control" name="precio_descuento" id="precio_descuento" placeholder="Precio Descuento">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="num_visitas">Num Visitas: </label>
                    <input type="text" class="form-control" name="num_visitas" id="num_visitas" placeholder="Num Visitas">
                  </div>
                </div>




              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-productos') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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
