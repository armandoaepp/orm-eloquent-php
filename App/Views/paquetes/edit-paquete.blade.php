
<?php
  $sidebar = array(
    "sidebar_class"  => "",
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );

?>


<?php
  $publicar = trim($paquete->publicar);

  $si = "";
  $no = "";

  if ($publicar == "S") {
      $si = "checked='checked'";
  } elseif ($publicar == "N") {
      $no = "checked='checked'";
  }
?>

@extends('layouts.app-admin')

@section('content')

<nav class="full-content" aria-label="breadcrumb">
  <ol class="breadcrumb breadcrumb-shape breadcrumb-theme shadow-sm radius-0">
    <li class="breadcrumb-item">
      <a href="{{ route('admin') }}">
        <i class="fas fa-home"></i> Home
      </a>
    </li>

    <li class="breadcrumb-item" aria-current="page">
      <a href="{{ route('admin-paquetes') }}" class="">
        <i class="fa fa-align-justify"></i> Paquetes
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar Paquete
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
          <i class="fa fa-align-justify"></i> Editar Paquete
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route('paquete-update') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $paquete->id }}">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="ubigeo_id">Ubigeo Id: </label>
                    <select class="custom-select select2-box" name="ubigeo_id" id="ubigeo_id" placeholder="Ubigeo Id">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="nombre">Nombre: </label>
                    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" value="{{ $paquete->nombre }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="descripcion">Descripcion: </label>
                    <textarea class="form-control ckeditor" name="descripcion" id="descripcion" placeholder="Descripcion" cols="30" rows="6">{{ $paquete->descripcion }}</textarea>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="recomendacion">Recomendacion: </label>
                    <textarea class="form-control ckeditor" name="recomendacion" id="recomendacion" placeholder="Recomendacion" cols="30" rows="6">{{ $paquete->recomendacion }}</textarea>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="num_dias">Num Dias: </label>
                    <input type="number" class="form-control" name="num_dias" id="num_dias" placeholder="Num Dias" value="{{ $paquete->num_dias }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="num_noches">Num Noches: </label>
                    <input type="number" class="form-control" name="num_noches" id="num_noches" placeholder="Num Noches" value="{{ $paquete->num_noches }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="precio">Precio: </label>
                    <input type="number" class="form-control" name="precio" id="precio" placeholder="Precio" value="{{ $paquete->precio }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="descuento">Descuento: </label>
                    <input type="number" class="form-control" name="descuento" id="descuento" placeholder="Descuento" value="{{ $paquete->descuento }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="precio_descuento">Precio Descuento: </label>
                    <input type="number" class="form-control" name="precio_descuento" id="precio_descuento" placeholder="Precio Descuento" value="{{ $paquete->precio_descuento }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="fecha_ini_promo">Fecha Ini Promo: </label>
                    <input type="date" class="form-control" name="fecha_ini_promo" id="fecha_ini_promo" placeholder="Fecha Ini Promo" value="{{ $paquete->fecha_ini_promo }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="fecha_fin_promo">Fecha Fin Promo: </label>
                    <input type="date" class="form-control" name="fecha_fin_promo" id="fecha_fin_promo" placeholder="Fecha Fin Promo" value="{{ $paquete->fecha_fin_promo }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="num_visitas">Num Visitas: </label>
                    <input type="number" class="form-control" name="num_visitas" id="num_visitas" placeholder="Num Visitas" value="{{ $paquete->num_visitas }}" >
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="email" class="d-block">Publicar </label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="publicar" id="si" value="S" <?php echo $si; ?> >
                      <label class="form-check-label" for="si">SI</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="publicar" id="no" value="N" <?php echo $no; ?> >
                      <label class="form-check-label" for="no">NO</label>
                    </div>
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">

                <a href="{{ route('admin-paquetes') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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


@endsection
