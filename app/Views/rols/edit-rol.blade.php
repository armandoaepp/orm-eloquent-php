@php
  $sidebar = array(
    "sidebar_active" => [0, 0],
  );
@endphp

@extends('layouts.app-admin')

@section('title')
  Rols
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
      <a href="{{ route('admin.rols') }}" class="">
        <i class="fa fa-align-justify"></i> Rols
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Rol
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
          <i class="fa fa-align-justify"></i> Editar Rol
        </div>
        <div class="card-body">
          <div class="col-12">
            @include('admin.rols.form-edit-rol')
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