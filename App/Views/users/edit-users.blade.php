
<?php
  $sidebar = array(
    "sidebar_class" => "",
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );

?>

@extends('layouts.app-admin')

@section('content')

<div class="kt-subheader   kt-grid__item" id="kt_subheader">
  <div class="kt-subheader__main">
    <h3 class="kt-subheader__title"> Users</h3>
    <span class="kt-subheader__separator kt-hidden"></span>
    <div class="kt-subheader__breadcrumbs">
      <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
      <span class="kt-subheader__breadcrumbs-separator"></span>
      <a href="#" class="kt-subheader__breadcrumbs-link">
        Maestros </a>
      <span class="kt-subheader__breadcrumbs-separator"></span>
      <a href="{{ route('admin-users') }}" class="kt-subheader__breadcrumbs-link">
      Users
      </a>
    </div>
  </div>
</div>

<!-- begin:: Content -->
<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
  <!-- begin:: Data List -->
  <div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head">
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">
          Editar Users
        </h3>
      </div>
    </div>
    <div class="kt-portlet__body position-relative">

        <div class="col-12">
          <form action="{{  route('users-update') }}" method="POST" enctype="multipart/form-data">
            @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $data->id }}">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="nombre">Nombre: </label>
                    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" value="{{ $data->nombre }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="apellidos">Apellidos: </label>
                    <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Apellidos" value="{{ $data->apellidos }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="email">Email: </label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="{{ $data->email }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="email_verified_at">Email Verified At: </label>
                    <input type="text" class="form-control" name="email_verified_at" id="email_verified_at" placeholder="Email Verified At" value="{{ $data->email_verified_at }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="password">Password: </label>
                    <input type="text" class="form-control" name="password" id="password" placeholder="Password" value="{{ $data->password }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="remember_token">Remember Token: </label>
                    <input type="text" class="form-control" name="remember_token" id="remember_token" placeholder="Remember Token" value="{{ $data->remember_token }}" >
                  </div>
                </div>




              </div>

            <div class="w-100 text-center">

                  <a href="{{ route('admin-users') }}" class="btn btn-danger btn-elevate btn-elevate-air"> <i class="fas fa-ban"></i>
                  Cancelar</a>
                <button type="submit" class="btn btn-brand btn-elevate btn-elevate-air"> <i class="fas fa-save"></i>
                  Guardar</button>
            </div>

          </form>
        </div>

    </div>
  </div>

  <!-- end:: Data List -->

</div>
<!-- end:: Content -->


@endsection


@section('script')


@endsection
