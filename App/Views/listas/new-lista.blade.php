
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
      <a href="{{ route('admin-listas') }}" class="">
      Listas
      </a>
    </li>

    <li class="breadcrumb-item active bg-info text-white" aria-current="page">
      <span>
      Nuevo Lista
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

            <form action="{{  route('lista-save') }}" method="POST" enctype="multipart/form-data">
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
                    <label for="desc_lista">Desc Lista: </label>
                    <input type="text" class="form-control" name="desc_lista" id="desc_lista" placeholder="Desc Lista">
                  </div>
                </div>




              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-listas') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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
