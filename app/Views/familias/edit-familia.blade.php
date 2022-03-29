@php
  $sidebar = array(
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );
@endphp

  $publicar = trim($familia->publicar);

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
  Familias
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
      <a href="{{ route('admin.familias') }}" class="">
        <i class="fa fa-align-justify"></i> Familias
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Familia
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
          <i class="fa fa-align-justify"></i> Editar Familia
        </div>
        <div class="card-body">
          <div class="col-12">
            @include('admin. familias.form-edit-familia')
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<!-- end:: Content -->

@endsection


@section('script')

  @include('shared.jquery-validation')

@endsection