@php
  $sidebar = array(
    "sidebar_active" => [0, 0],
  );
@endphp

@extends('layouts.app-admin')

@section('title')
  Estado Citas
@endsection

@section('content')

<nav class="full-content" aria-label="breadcrumb">
  <ol class="breadcrumb breadcrumb-shape breadcrumb-theme shadow-sm radius-0">
    <li class="breadcrumb-item">
      <a href="{{ route('admin') }}">
        <i class="fas fa-home"></i> Home
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Estado Citas
      </span>
    </li>
  </ol>
</nav>

<!-- begin:: Content -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12 mb-3">
      <a href="#" data-table-reload="list-table" data-href="{{ route('admin.estado-citas.list-table') }}" class="btn btn-outline-primary btn-sm" type="button">
        <i class="fas fa-list-ul"></i>
        Listar
      </a>
      <a href="#" data-btn-open="modal-create" data-href="{{ route('admin.estado-citas.create') }}" class="btn btn-outline-primary btn-sm" type="button">
        <i class="fa fa-file-o"></i>
        Nuevo
      </a>
    </div>

    <div class="col-12">
      <div class="card">
        <div class="card-header bg-white">
          <i class="fa fa-align-justify"></i> Lista de estado-citas
        </div>
        <div class="card-body">
         <div id="wrap-table" data-wrap-table="list-table" class="table-responsive">
           @include('admin.estado-citas.list-table-estado-citas')
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<!-- end:: Content -->
@endsection

<!-- Start:: Section modal  -->
@section('modal')
  <x-modals.modal-create title="Nuevo Estado_cita">
  {{-- @include('admin.estado-citas.form-create-estado_cita') --}}
  </x-modals.modal-create>

  <x-modals.modal-edit title="Editar Estado_cita" />

  <x-forms.form-post form-id="form-delete" url="{{ route('admin.estado-citas.delete') }}" class="d-none" />
  <x-forms.form-destroy table="Estado-cita" url="{{ route('admin.estado-citas.destroy') }}" />  
@endsection

<!-- Start:: Section script  -->
@section('script')

  @include('shared.datatables')

  <script src="{{ asset('assets/js/app-admin.js') }}"></script>

@endsection