
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
      <a href="{{ route('admin-notificacions') }}" class="">
        <i class="fa fa-align-justify"></i> Notificacions
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Notificacion
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
          <i class="fa fa-align-justify"></i> Editar Notificacion
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('notificacion-update') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $notificacion->id }}">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="user_id">User Id: </label>
                    <select class="custom-select select2-box" name="user_id" id="user_id" placeholder="User Id">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="asunto">Asunto: </label>
                    <input type="text" class="form-control" name="asunto" id="asunto" placeholder="Asunto" value="{{ $notificacion->asunto }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="destino">Destino: </label>
                    <input type="text" class="form-control" name="destino" id="destino" placeholder="Destino" value="{{ $notificacion->destino }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="mensaje">Mensaje: </label>
                    <textarea class="form-control ckeditor" name="mensaje" id="mensaje" placeholder="Mensaje" cols="30" rows="6">{{ $notificacion->mensaje }}</textarea>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="referencia">Referencia: </label>
                    <input type="text" class="form-control" name="referencia" id="referencia" placeholder="Referencia" value="{{ $notificacion->referencia }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="tipo">Tipo: </label>
                    <input type="text" class="form-control" name="tipo" id="tipo" placeholder="Tipo" value="{{ $notificacion->tipo }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="fecha_envio">Fecha Envio: </label>
                    <input type="date" class="form-control" name="fecha_envio" id="fecha_envio" placeholder="Fecha Envio" value="{{ $notificacion->fecha_envio }}" >
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-notificacions') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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
