@php
  $sidebar = array(
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );
@endphp

@extends('layouts.app-admin')

@section('title')
  Categorias
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
      Categorias
      </span>
    </li>
  </ol>
</nav>

<!-- begin:: Content -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12 mb-3">
      <a href="#" data-reload="list-table" data-href="{{ route('admin.categorias') }}" class="btn btn-outline-secondary btn-sm" type="button">
        <i class="fas fa-list-ul"></i>
        Listar
      </a>
      <a href="#" id="btn-create" data-href="{{ route('admin.categorias.create') }}" class="btn btn-outline-secondary btn-sm" type="button">
        <i class="fas fa-file"></i>
        Nuevo
      </a>
    </div>

    <div class="col-12">
      <div class="card">
        <div class="card-header bg-white">
          <i class="fa fa-align-justify"></i> Lista de categorias
        </div>
        <div class="card-body">
         <div id="wrap-table" class="table-responsive">
           @include('admin. categorias.list-table-categorias')
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
  <x-modals.modal-create title="Nuevo Categoria">
    @include('admin.categorias.form-create-categoria')
  </x-modals.modal-create>

  <x-modals.modal-edit title="Editar Categoria" />

  <x-forms.form-post form-id="form-delete" url="{{ route('admin.categorias.delete') }}" class="d-none" />
  <x-forms.form-destroy table="Categoria" />  
  <x-forms.form-publish url="{{ route('admin.categorias.publish') }}" /> 
@endsection

<!-- Start:: Section script  -->
@section('script')

  @include('shared.datatables')

  <script src="{{ asset('assets/js/app-form-modals.js') }}"></script>

@endsection