
<?php
  $sidebar = array(
    "sidebar_class" => "",
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

    <li class="breadcrumb-item active bg-info text-white" aria-current="page">
      <a class="link-white" href="{{ route('admin-empresas') }}">
        Empresas
      </a>
    </li>

    <li class="breadcrumb-item active bg-info text-white" aria-current="page">
      <span> Editar Empresa </span>
    </li>

  </ol>
</nav>

<div class="container-fluid">
  <div class="row">


    <div class="col-12">
      <div class="card">
        <div class="card-header bg-white">
          <i class="fa fa-align-justify"></i> Editar Empresa
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{ route('empresa-update') }}" method="POST" enctype="multipart/form-data">
              @csrf
               <input type="hidden" class="form-control" name="id" id="id" value="{{ $data->empresa_id }}">
              <div class="row"> 
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="empresa_id">EmpresaId: </label>
                    <input type="text" class="form-control" name="empresa_id" id="empresa_id" placeholder="EmpresaId" value="{{ $data->empresa_id }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="ruc">Ruc: </label>
                    <input type="text" class="form-control" name="ruc" id="ruc" placeholder="Ruc" value="{{ $data->ruc }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="razonsocial">Razonsocial: </label>
                    <input type="text" class="form-control" name="razonsocial" id="razonsocial" placeholder="Razonsocial" value="{{ $data->razonsocial }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="direccion">Direccion: </label>
                    <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Direccion" value="{{ $data->direccion }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="telefono">Telefono: </label>
                    <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Telefono" value="{{ $data->telefono }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="celular">Celular: </label>
                    <input type="text" class="form-control" name="celular" id="celular" placeholder="Celular" value="{{ $data->celular }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="paginaweb">Paginaweb: </label>
                    <input type="text" class="form-control" name="paginaweb" id="paginaweb" placeholder="Paginaweb" value="{{ $data->paginaweb }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="estado">Estado: </label>
                    <input type="text" class="form-control" name="estado" id="estado" placeholder="Estado" value="{{ $data->estado }}" >
                  </div>
                </div>



              </div>

              <div class="w-100 text-center">
                <a href="{{ route('admin-empresas') }}" type="button" class="btn btn-dark "> <i class="fas fa-ban"></i>
                  Cancelar</a>
                <button type="submit" class="btn btn-secondary rounded-0 text-white"> <i class="fas fa-save"></i>
                  Guardar</button>
              </div>

            </form>
          </div>

        </div>
      </div>
    </div>

  </div>

</div>

@endsection


@section('script')


@endsection
