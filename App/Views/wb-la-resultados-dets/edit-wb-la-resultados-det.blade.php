@php
  $sidebar = array(
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );

@extends('layouts.app-admin')

@section('title')
  Wb La Resultados Dets
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
      <a href="{{ route('admin-wb-la-resultados-dets') }}" class="">
        <i class="fa fa-align-justify"></i> Wb La Resultados Dets
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Wb La Resultados Det
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
          <i class="fa fa-align-justify"></i> Editar Wb La Resultados Det
        </div>
        <div class="card-body">
          <div class="col-12">

            <form id="form-controls" action="{{ route('wb-la-resultados-det-update',['id' => $wb_la_resultados_det->invnum]) }}" method="POST" enctype="multipart/form-data">
              @csrf @method("put")
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $wb_la_resultados_det->invnum }}">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="exacod">Exacod: </label>
                    <input type="text" class="form-control  @error('exacod') is-invalid @enderror" name="exacod" id="exacod" placeholder="Exacod" value="{{ old('exacod', $wb_la_resultados_det->exacod ?? '') }}" >
                    @error('exacod')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="exades">Exades: </label>
                    <input type="text" class="form-control  @error('exades') is-invalid @enderror" name="exades" id="exades" placeholder="Exades" value="{{ old('exades', $wb_la_resultados_det->exades ?? '') }}" >
                    @error('exades')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="numitm">Numitm: </label>
                    <input type="text" class="form-control  @error('numitm') is-invalid @enderror" name="numitm" id="numitm" placeholder="Numitm" value="{{ old('numitm', $wb_la_resultados_det->numitm ?? '') }}" >
                    @error('numitm')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="numprm">Numprm: </label>
                    <input type="text" class="form-control  @error('numprm') is-invalid @enderror" name="numprm" id="numprm" placeholder="Numprm" value="{{ old('numprm', $wb_la_resultados_det->numprm ?? '') }}" >
                    @error('numprm')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="codprm">Codprm: </label>
                    <input type="text" class="form-control  @error('codprm') is-invalid @enderror" name="codprm" id="codprm" placeholder="Codprm" value="{{ old('codprm', $wb_la_resultados_det->codprm ?? '') }}" >
                    @error('codprm')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="desprm">Desprm: </label>
                    <input type="text" class="form-control  @error('desprm') is-invalid @enderror" name="desprm" id="desprm" placeholder="Desprm" value="{{ old('desprm', $wb_la_resultados_det->desprm ?? '') }}" >
                    @error('desprm')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="estprm">Estprm: </label>
                    <input type="text" class="form-control  @error('estprm') is-invalid @enderror" name="estprm" id="estprm" placeholder="Estprm" value="{{ old('estprm', $wb_la_resultados_det->estprm ?? '') }}" >
                    @error('estprm')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="obsres">Obsres: </label>
                    <input type="text" class="form-control  @error('obsres') is-invalid @enderror" name="obsres" id="obsres" placeholder="Obsres" value="{{ old('obsres', $wb_la_resultados_det->obsres ?? '') }}" >
                    @error('obsres')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="und">Und: </label>
                    <input type="text" class="form-control  @error('und') is-invalid @enderror" name="und" id="und" placeholder="Und" value="{{ old('und', $wb_la_resultados_det->und ?? '') }}" >
                    @error('und')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="tifprm">Tifprm: </label>
                    <input type="text" class="form-control  @error('tifprm') is-invalid @enderror" name="tifprm" id="tifprm" placeholder="Tifprm" value="{{ old('tifprm', $wb_la_resultados_det->tifprm ?? '') }}" >
                    @error('tifprm')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="valref">Valref: </label>
                    <input type="text" class="form-control  @error('valref') is-invalid @enderror" name="valref" id="valref" placeholder="Valref" value="{{ old('valref', $wb_la_resultados_det->valref ?? '') }}" >
                    @error('valref')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="valref2">Valref2: </label>
                    <input type="text" class="form-control  @error('valref2') is-invalid @enderror" name="valref2" id="valref2" placeholder="Valref2" value="{{ old('valref2', $wb_la_resultados_det->valref2 ?? '') }}" >
                    @error('valref2')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="ran1">Ran1: </label>
                    <input type="text" class="form-control  @error('ran1') is-invalid @enderror" name="ran1" id="ran1" placeholder="Ran1" value="{{ old('ran1', $wb_la_resultados_det->ran1 ?? '') }}" >
                    @error('ran1')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="ran2">Ran2: </label>
                    <input type="text" class="form-control  @error('ran2') is-invalid @enderror" name="ran2" id="ran2" placeholder="Ran2" value="{{ old('ran2', $wb_la_resultados_det->ran2 ?? '') }}" >
                    @error('ran2')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="resexa_n">Resexa N: </label>
                    <input type="text" class="form-control  @error('resexa_n') is-invalid @enderror" name="resexa_n" id="resexa_n" placeholder="Resexa N" value="{{ old('resexa_n', $wb_la_resultados_det->resexa_n ?? '') }}" >
                    @error('resexa_n')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="color">Color: </label>
                    <input type="text" class="form-control  @error('color') is-invalid @enderror" name="color" id="color" placeholder="Color" value="{{ old('color', $wb_la_resultados_det->color ?? '') }}" >
                    @error('color')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="res">Res: </label>
                    <input type="text" class="form-control  @error('res') is-invalid @enderror" name="res" id="res" placeholder="Res" value="{{ old('res', $wb_la_resultados_det->res ?? '') }}" >
                    @error('res')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="res2">Res2: </label>
                    <input type="text" class="form-control  @error('res2') is-invalid @enderror" name="res2" id="res2" placeholder="Res2" value="{{ old('res2', $wb_la_resultados_det->res2 ?? '') }}" >
                    @error('res2')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="rentre">Rentre: </label>
                    <input type="text" class="form-control  @error('rentre') is-invalid @enderror" name="rentre" id="rentre" placeholder="Rentre" value="{{ old('rentre', $wb_la_resultados_det->rentre ?? '') }}" >
                    @error('rentre')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="estado_wb">Estado Wb: </label>
                    <input type="text" class="form-control  @error('estado_wb') is-invalid @enderror" name="estado_wb" id="estado_wb" placeholder="Estado Wb" value="{{ old('estado_wb', $wb_la_resultados_det->estado_wb ?? '') }}" >
                    @error('estado_wb')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-wb-la-resultados-dets') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>

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

  @include('shared.jquery-validation')

@endsection