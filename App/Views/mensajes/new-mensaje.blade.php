
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

    <li class="breadcrumb-item" aria-current="page">
      <a href="{{ route('admin-mensajes') }}" class="">
      Mensajes
      </a>
    </li>

    <li class="breadcrumb-item active bg-info text-white" aria-current="page">
      <span>
      Nuevo Mensaje
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
          <i class="fa fa-align-justify"></i> Nuevo Plan
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('mensaje-save') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="lista_contacto_id">Lista Contacto Id: </label>
                    <select class="custom-select" name="lista_contacto_id" id="lista_contacto_id" placeholder="Lista Contacto Id">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="email">Email: </label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="asunto">Asunto: </label>
                    <input type="text" class="form-control" name="asunto" id="asunto" placeholder="Asunto">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="header">Header: </label>
                    <textarea class="form-control ckeditor" name="header" id="header" placeholder="Header" cols="30" rows="6"></textarea>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="body">Body: </label>
                    <textarea class="form-control ckeditor" name="body" id="body" placeholder="Body" cols="30" rows="6"></textarea>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="glosa">Glosa: </label>
                    <input type="text" class="form-control" name="glosa" id="glosa" placeholder="Glosa">
                  </div>
                </div>




              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-mensajes') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
                <button type="submit" class="btn btn-outline-brand"> <i class="fas fa-save"></i> Guardar</button>

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
