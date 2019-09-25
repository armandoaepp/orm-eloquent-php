
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
      <a href="{{ route('admin-bitacoras') }}" class="">
        <i class="fa fa-align-justify"></i> Bitacoras
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Bitacora
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
          <i class="fa fa-align-justify"></i> Editar Bitacora
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('bitacora-update') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $bitacora->id }}">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="user_id">User Id: </label>
                    <input type="text" class="form-control" name="user_id" id="user_id" placeholder="User Id" value="{{ $bitacora->user_id }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="action">Action: </label>
                    <input type="text" class="form-control" name="action" id="action" placeholder="Action" value="{{ $bitacora->action }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="table_id">Table Id: </label>
                    <input type="text" class="form-control" name="table_id" id="table_id" placeholder="Table Id" value="{{ $bitacora->table_id }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="table">Table: </label>
                    <input type="text" class="form-control" name="table" id="table" placeholder="Table" value="{{ $bitacora->table }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="computer_ip">Computer Ip: </label>
                    <input type="text" class="form-control" name="computer_ip" id="computer_ip" placeholder="Computer Ip" value="{{ $bitacora->computer_ip }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="new_value">New Value: </label>
                    <input type="text" class="form-control" name="new_value" id="new_value" placeholder="New Value" value="{{ $bitacora->new_value }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="old_value">Old Value: </label>
                    <input type="text" class="form-control" name="old_value" id="old_value" placeholder="Old Value" value="{{ $bitacora->old_value }}" >
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-bitacoras') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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
