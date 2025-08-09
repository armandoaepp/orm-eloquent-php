@php
  $sidebar = array(
    "sidebar_active" => [0, 0],
  );
@endphp

@extends('layouts.app-admin')

@section('title')
  Concepto Planillas
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
      Concepto Planillas
      </span>
    </li>
  </ol>
</nav>

<!-- begin:: Content -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12 mb-3">
      <a href="#" data-table-reload="list-table" data-href="{{ route('admin.concepto-planillas.list-table') }}" class="btn btn-outline-primary btn-sm" type="button">
        <i class="fas fa-list-ul"></i>
        Listar
      </a>
      <a href="#" data-btn-open="modal-create" data-href="{{ route('admin.concepto-planillas.create') }}" class="btn btn-outline-primary btn-sm" type="button">
        <i class="fa fa-file-o"></i>
        Nuevo
      </a>
    </div>

    <div class="col-12">
      <div class="card">
        <div class="card-header bg-white">
          <i class="fa fa-align-justify"></i> Lista de concepto-planillas
        </div>
        <div class="card-body">
         <div id="wrap-table" data-wrap-table="list-table" class="table-responsive">
           @include('admin.concepto-planillas.list-table-concepto-planillas')
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
  <x-modals.modal-create title="Nuevo Concepto_planilla">
  {{-- @include('admin.concepto-planillas.form-create-concepto_planilla') --}}
  </x-modals.modal-create>

  <x-modals.modal-edit title="Editar Concepto_planilla" />

  <x-forms.form-post form-id="form-delete" url="{{ route('admin.concepto-planillas.delete') }}" class="d-none" />
  <x-forms.form-destroy table="Concepto-planilla" url="{{ route('admin.concepto-planillas.destroy') }}" />  
@endsection

<!-- Start:: Section script  -->
@section('script')

  @include('shared.datatables')

  <script src="{{ asset('assets/js/app-admin.js') }}"></script>

@endsection