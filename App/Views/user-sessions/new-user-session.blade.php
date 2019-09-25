
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
      <a href="{{ route('admin-user-sessions') }}" class="">
        <i class="fa fa-align-justify"></i> User Sessions
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Nuevo User Session
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
          <i class="fa fa-align-justify"></i> Nuevo User Session
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('user-session-store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="">
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
                    <label for="date_login">Date Login: </label>
                    <input type="text" class="form-control" name="date_login" id="date_login" placeholder="Date Login">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="date_logout">Date Logout: </label>
                    <input type="text" class="form-control" name="date_logout" id="date_logout" placeholder="Date Logout">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="token">Token: </label>
                    <input type="text" class="form-control" name="token" id="token" placeholder="Token">
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-user-sessions') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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
