@php
  $sidebar = array(
    "sidebar_active" => [0, 0],
  );
@endphp

  $publicar = trim($sub_categoria->publicar);

  $si = "";
  $no = "";

  if ($publicar == "S") {
    $si = "checked='checked'";
  } elseif ($publicar == "N") {
    $no = "checked='checked'";
  }
@endphp

@extends('layouts.app-admin')

@section('title')
  Sub Categorias
@endsection

@section('content')

<nav class="full-content" aria-label="breadcrumb">
  <ol class="breadcrumb breadcrumb-shape breadcrumb-theme shadow-sm radius-0">
    <li class="breadcrumb-item">
      <a href="{{ route('admin') }}">
        <i class="fas fa-home"></i> Home
      </a>
    </li>

    <li class="breadcrumb-item" aria-current="page">
      <a href="{{ route('admin.sub categorias') }}" class="">
        <i class="fa fa-align-justify"></i> Sub Categorias
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Sub Categoria
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
          <i class="fa fa-align-justify"></i> Editar Sub Categoria
        </div>
        <div class="card-body">
          <div class="col-12">
            @include('admin.sub categorias.form-edit-sub_categoria')
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