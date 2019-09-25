
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
      <a href="{{ route('admin-users') }}" class="">
        <i class="fa fa-align-justify"></i> Users
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Nuevo Users
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
          <i class="fa fa-align-justify"></i> Nuevo Users
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('users-store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="per_id_padre">Per Id Padre: </label>
                    <input type="text" class="form-control" name="per_id_padre" id="per_id_padre" placeholder="Per Id Padre">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="rol_id">Rol Id: </label>
                    <select class="custom-select select2-box" name="rol_id" id="rol_id" placeholder="Rol Id">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="persona_id">Persona Id: </label>
                    <select class="custom-select select2-box" name="persona_id" id="persona_id" placeholder="Persona Id">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="email">Email: </label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="password">Password: </label>
                    <input type="text" class="form-control" name="password" id="password" placeholder="Password">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="nombre">Nombre: </label>
                    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="apellidos">Apellidos: </label>
                    <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Apellidos">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="alias">Alias: </label>
                    <input type="text" class="form-control" name="alias" id="alias" placeholder="Alias">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="email_verified_at">Email Verified At: </label>
                    <input type="text" class="form-control" name="email_verified_at" id="email_verified_at" placeholder="Email Verified At">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="remember_token">Remember Token: </label>
                    <input type="text" class="form-control" name="remember_token" id="remember_token" placeholder="Remember Token">
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-users') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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
