@php
  $sidebar = array(
    "sidebar_active" => [0, 0],
  );
@endphp

@extends('layouts.app-admin')

@section('title')
  Persona Doc Identidads
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
      Persona Doc Identidads
      </span>
    </li>
  </ol>
</nav>

<!-- begin:: Content -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12 mb-3">
      <a href="#" data-reload="list-table" data-href="{{ route('admin.persona-doc-identidads'.list-table) }}" class="btn btn-outline-primary btn-sm" type="button">
        <i class="fas fa-list-ul"></i>
        Listar
      </a>
      <a href="#" id="btn-create" data-href="{{ route('admin.persona-doc-identidads.create') }}" class="btn btn-outline-primary btn-sm" type="button">
        <i class="fas fa-file"></i>
        Nuevo
      </a>
    </div>

    <div class="col-12">
      <div class="card">
        <div class="card-header bg-white">
          <i class="fa fa-align-justify"></i> Lista de persona-doc-identidads
        </div>
        <div class="card-body">
         <div id="wrap-table" class="table-responsive">
           @include('admin.persona-doc-identidads.list-table-persona-doc-identidads')
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
  <x-modals.modal-create title="Nuevo Persona_doc_identidad">
  {{-- @include('admin.persona-doc-identidads.form-create-persona_doc_identidad') --}}
  </x-modals.modal-create>

  <x-modals.modal-edit title="Editar Persona_doc_identidad" />

  <x-forms.form-post form-id="form-delete" url="{{ route('admin.persona-doc-identidads.delete') }}" class="d-none" />
  <x-forms.form-destroy table="Persona-doc-identidad" url="{{ route('admin.persona-doc-identidads.destroy') }}" />  
@endsection

<!-- Start:: Section script  -->
@section('script')

  @include('shared.datatables')

  <script src="{{ asset('assets/js/app-admin.js') }}"></script>

@endsection