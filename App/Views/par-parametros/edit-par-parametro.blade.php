
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
      <a href="{{ route('admin-par-parametros') }}" class="">
        <i class="fa fa-align-justify"></i> Par Parametros
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Par Parametro
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
          <i class="fa fa-align-justify"></i> Editar Par Parametro
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('par-parametro-update') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $par_parametro->id }}">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="per_id_padre">Per Id Padre: </label>
                    <input type="text" class="form-control" name="per_id_padre" id="per_id_padre" placeholder="Per Id Padre" value="{{ $par_parametro->per_id_padre }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="parametro_id">Parametro Id: </label>
                    <input type="text" class="form-control" name="parametro_id" id="parametro_id" placeholder="Parametro Id" value="{{ $par_parametro->parametro_id }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pp_codigo">Codigo: </label>
                    <input type="text" class="form-control" name="pp_codigo" id="pp_codigo" placeholder="Codigo" value="{{ $par_parametro->pp_codigo }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pp_jerarquia">Jerarquia: </label>
                    <input type="text" class="form-control" name="pp_jerarquia" id="pp_jerarquia" placeholder="Jerarquia" value="{{ $par_parametro->pp_jerarquia }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pp_nombre">Nombre: </label>
                    <input type="text" class="form-control" name="pp_nombre" id="pp_nombre" placeholder="Nombre" value="{{ $par_parametro->pp_nombre }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pp_descripcion">Descripcion: </label>
                    <input type="text" class="form-control" name="pp_descripcion" id="pp_descripcion" placeholder="Descripcion" value="{{ $par_parametro->pp_descripcion }}" >
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-par-parametros') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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
