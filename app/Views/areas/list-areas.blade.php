@php
  $sidebar = array(
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );
@endphp

@extends('layouts.app-admin')

@section('title')
  Areas
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
      Areas
      </span>
    </li>
  </ol>
</nav>

<!-- begin:: Content -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12 mb-3">
      <a href="#" data-reload="list-table" data-href="{{ route('admin.areas') }}" class="btn btn-outline-secondary btn-sm" type="button">
        <i class="fas fa-list-ul"></i>
        Listar
      </a>
      <a href="#" id="btn-create" data-href="{{ route('admin.areas.create') }}" class="btn btn-outline-secondary btn-sm" type="button">
        <i class="fas fa-file"></i>
        Nuevo
      </a>
    </div>

    <div class="col-12">
      <div class="card">
        <div class="card-header bg-white">
          <i class="fa fa-align-justify"></i> Lista de areas
        </div>
        <div class="card-body">
         <div id="wrap-table" class="table-responsive">
           @include('admin. areas.list-table-areas')
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
  <x-modals.modal-create title="Nuevo Area">
    @include('admin.areas.form-create-area')
  </x-modals.modal-create>

  <x-modals.modal-edit title="Editar Area" />

  <x-forms.form-post form-id="form-delete" url="{{ route('admin.areas.delete') }}" class="d-none" />
  <x-forms.form-destroy table="Area" />  
  <x-forms.form-publish url="{{ route('admin.areas.publish') }}" /> 
@endsection

<!-- Start:: Section script  -->
@section('script')

  @include('shared.datatables')

  <script src="{{ asset('assets/js/app-form-modals.js') }}"></script>

@endsection