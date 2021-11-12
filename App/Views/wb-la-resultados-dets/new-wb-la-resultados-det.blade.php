@php
  $sidebar = array(
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );
@endphp

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
      Nuevo Wb La Resultados Det
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
          <i class="fa fa-align-justify"></i> Nuevo Wb La Resultados Det
        </div>
        <div class="card-body">
          <div class="col-12">

            <form id="form-controls" action="{{  route('wb-la-resultados-det-store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="exacod">Exacod: </label>
                    <input type="text" class="form-control @error('exacod') is-invalid @enderror" name="exacod" id="exacod" value="{{ old('exacod') }}" required placeholder="Exacod">
                    @error('exacod')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="exades">Exades: </label>
                    <input type="text" class="form-control @error('exades') is-invalid @enderror" name="exades" id="exades" value="{{ old('exades') }}" required placeholder="Exades">
                    @error('exades')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="numitm">Numitm: </label>
                    <input type="text" class="form-control @error('numitm') is-invalid @enderror" name="numitm" id="numitm" value="{{ old('numitm') }}" required placeholder="Numitm">
                    @error('numitm')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="numprm">Numprm: </label>
                    <input type="text" class="form-control @error('numprm') is-invalid @enderror" name="numprm" id="numprm" value="{{ old('numprm') }}" required placeholder="Numprm">
                    @error('numprm')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="codprm">Codprm: </label>
                    <input type="text" class="form-control @error('codprm') is-invalid @enderror" name="codprm" id="codprm" value="{{ old('codprm') }}"  placeholder="Codprm">
                    @error('codprm')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="desprm">Desprm: </label>
                    <input type="text" class="form-control @error('desprm') is-invalid @enderror" name="desprm" id="desprm" value="{{ old('desprm') }}"  placeholder="Desprm">
                    @error('desprm')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="estprm">Estprm: </label>
                    <input type="text" class="form-control @error('estprm') is-invalid @enderror" name="estprm" id="estprm" value="{{ old('estprm') }}"  placeholder="Estprm">
                    @error('estprm')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="obsres">Obsres: </label>
                    <input type="text" class="form-control @error('obsres') is-invalid @enderror" name="obsres" id="obsres" value="{{ old('obsres') }}"  placeholder="Obsres">
                    @error('obsres')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="und">Und: </label>
                    <input type="text" class="form-control @error('und') is-invalid @enderror" name="und" id="und" value="{{ old('und') }}"  placeholder="Und">
                    @error('und')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="tifprm">Tifprm: </label>
                    <input type="text" class="form-control @error('tifprm') is-invalid @enderror" name="tifprm" id="tifprm" value="{{ old('tifprm') }}"  placeholder="Tifprm">
                    @error('tifprm')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="valref">Valref: </label>
                    <input type="text" class="form-control @error('valref') is-invalid @enderror" name="valref" id="valref" value="{{ old('valref') }}"  placeholder="Valref">
                    @error('valref')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="valref2">Valref2: </label>
                    <input type="text" class="form-control @error('valref2') is-invalid @enderror" name="valref2" id="valref2" value="{{ old('valref2') }}"  placeholder="Valref2">
                    @error('valref2')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="ran1">Ran1: </label>
                    <input type="text" class="form-control @error('ran1') is-invalid @enderror" name="ran1" id="ran1" value="{{ old('ran1') }}"  placeholder="Ran1">
                    @error('ran1')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="ran2">Ran2: </label>
                    <input type="text" class="form-control @error('ran2') is-invalid @enderror" name="ran2" id="ran2" value="{{ old('ran2') }}"  placeholder="Ran2">
                    @error('ran2')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="resexa_n">Resexa N: </label>
                    <input type="text" class="form-control @error('resexa_n') is-invalid @enderror" name="resexa_n" id="resexa_n" value="{{ old('resexa_n') }}"  placeholder="Resexa N">
                    @error('resexa_n')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="color">Color: </label>
                    <input type="text" class="form-control @error('color') is-invalid @enderror" name="color" id="color" value="{{ old('color') }}"  placeholder="Color">
                    @error('color')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="res">Res: </label>
                    <input type="text" class="form-control @error('res') is-invalid @enderror" name="res" id="res" value="{{ old('res') }}"  placeholder="Res">
                    @error('res')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="res2">Res2: </label>
                    <input type="text" class="form-control @error('res2') is-invalid @enderror" name="res2" id="res2" value="{{ old('res2') }}"  placeholder="Res2">
                    @error('res2')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="rentre">Rentre: </label>
                    <input type="text" class="form-control @error('rentre') is-invalid @enderror" name="rentre" id="rentre" value="{{ old('rentre') }}"  placeholder="Rentre">
                    @error('rentre')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="estado_wb">Estado Wb: </label>
                    <input type="text" class="form-control @error('estado_wb') is-invalid @enderror" name="estado_wb" id="estado_wb" value="{{ old('estado_wb') }}"  placeholder="Estado Wb">
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