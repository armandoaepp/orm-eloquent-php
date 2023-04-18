@php
  $sidebar = array(
    "sidebar_active" => [0, 0],
  );
@endphp

@extends('layouts.app-admin')

@section('title')
  Tipo Especialidads
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
      Tipo Especialidads
      </span>
    </li>
  </ol>
</nav>

<!-- begin:: Content -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12 mb-3">
      <a href="#" data-reload="list-table" data-href="{{ route('admin.tipo-especialidads') }}" class="btn btn-outline-primary btn-sm" type="button">
        <i class="fas fa-list-ul"></i>
        Listar
      </a>
      <a href="#" id="btn-create" data-href="{{ route('admin.tipo-especialidads.create') }}" class="btn btn-outline-primary btn-sm" type="button">
        <i class="fas fa-file"></i>
        Nuevo
      </a>
    </div>

    <div class="col-12">
      <div class="card">
        <div class="card-header bg-white">
          <i class="fa fa-align-justify"></i> Lista de tipo-especialidads
        </div>
        <div class="card-body">
         <div id="wrap-table" class="table-responsive">
           @include('admin.tipo-especialidads.list-table-tipo-especialidads')
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
  <x-modals.modal-create title="Nuevo Tipo_especialidad">
  {{-- @include('admin.tipo-especialidads.form-create-tipo_especialidad') --}}
  </x-modals.modal-create>

  <x-modals.modal-edit title="Editar Tipo_especialidad" />

  <x-forms.form-post form-id="form-delete" url="{{ route('admin.tipo-especialidads.delete') }}" class="d-none" />
  <x-forms.form-destroy table="Tipo-especialidad" url="{{ route('admin.tipo-especialidads.destroy') }}" />  
  <x-forms.form-publish url="{{ route('admin.tipo-especialidads.publish') }}" /> 
@endsection

<!-- Start:: Section script  -->
@section('script')

  @include('shared.datatables')

  <script src="{{ asset('assets/js/app-admin.js') }}"></script>

@endsection