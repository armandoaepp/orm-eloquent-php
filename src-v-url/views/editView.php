<?php
use Illuminate\Support\Str;

function generateEditView($table_name, $class_name, $entities = array(), $fields_table, $heads_table = array() , $tipo_inputs = array() )
{
  $table_amigable = App\Helpers\UrlHelper::urlFriendly($table_name);
  $table_amigable_sin_guion = str_replace ('-', ' ', $table_amigable);

  $table_plural = Str::plural($table_amigable_sin_guion) ;

  $url_friendly_plural = str_replace (' ', '-', $table_plural);
  // $title = ucwords(str_replace ('-', ' ', $title_lower));
  $title = ucwords($table_plural);

  $prefix =  generatePrefixTable( $table_name ) ;
  $prefix = !empty($prefix) ? $prefix."_" : "" ;

$html = '';
$html .= '@php
  $sidebar = array(
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );
@endphp
' ;

if(in_array("publicar", $fields_table) || in_array($prefix."publicar", $fields_table))
{

  $name_publicar = (in_array("publicar", $fields_table) ) ? 'publicar' : $prefix."publicar" ;

$html .= '
  $publicar = trim($'. $table_name .'->'.$name_publicar.');

  $si = "";
  $no = "";

  if ($publicar == "S") {
    $si = "checked=\'checked\'";
  } elseif ($publicar == "N") {
    $no = "checked=\'checked\'";
  }
@endphp'. PHP_EOL ;

}

$html .= '
@extends(\'layouts.app-admin\')

@section(\'title\')
  '.$title .'
@endsection

@section(\'content\')

<nav class="full-content" aria-label="breadcrumb">
  <ol class="breadcrumb breadcrumb-shape breadcrumb-theme shadow-sm radius-0">
    <li class="breadcrumb-item">
      <a href="{{ route(\''.$GLOBALS['prefix_route'].'\') }}">
        <i class="fas fa-home"></i> Home
      </a>
    </li>

    <li class="breadcrumb-item" aria-current="page">
      <a href="{{ route(\''.$GLOBALS["prefix_route"].'.'.$table_plural.'\') }}" class="">
        <i class="fa fa-align-justify"></i> '.$title.'
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      Editar '.ucwords($table_amigable_sin_guion).'
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
          <i class="fa fa-align-justify"></i> Editar '.ucwords($table_amigable_sin_guion).'
        </div>
        <div class="card-body">
          <div class="col-12">

            <form id="form-controls" action="{{ route(\''.$GLOBALS['prefix_route'].'.'.$table_plural.'.update\',[\'id\' => $'. $table_name .'->'.$fields_table[0].']) }}" method="POST" enctype="multipart/form-data">
              @csrf @method("put")
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $'. $table_name .'->'.$fields_table[0].' }}">
              <div class="row">' . PHP_EOL;

              for ($i=1; $i < count( $fields_table) ; $i++)
              {
                 // ==== Start remove prefix
                 $field_item = $heads_table[$i] ;
                 if(!empty($prefix))
                 {
                   $field_item = revemoPrefix($field_item, $prefix)  ;
                 }
                 $field_item = toCamelCase($field_item);

                 // ==== Start remove prefix

                if ( !verificarItemForm($fields_table[$i], $prefix) )
                {

                  if($tipo_inputs[$i] == 'textarea')
                  {
                    $html .= '                <div class="col-md-12">' . PHP_EOL;
                    $html .= '                  <div class="form-group">' . PHP_EOL;
                    $html .= '                    <label for="' . $fields_table[$i] . '">' . $field_item  . ': </label>' . PHP_EOL;
                    $html .= '                    <textarea class="form-control ckeditor  @error(\'' . $fields_table[$i] .'\') is-invalid @enderror" name="' . $fields_table[$i] .'" id="' . $fields_table[$i] .'" placeholder="' . $field_item  . '" cols="30" rows="6">{{ $'. $table_name .'->'.$fields_table[$i].' }}</textarea>' . PHP_EOL;
                    $html .= '                    @error(\'' . $fields_table[$i] .'\')' . PHP_EOL;
                    $html .= '                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>' . PHP_EOL;
                    $html .= '                    @enderror' . PHP_EOL;
                    $html .= '                  </div>' . PHP_EOL;
                    $html .= '                </div>' . PHP_EOL;
                    $html .= '' . PHP_EOL;
                  }
                  elseif($tipo_inputs[$i] == 'select')
                  {
                    $html .= '                <div class="col-md-12">' . PHP_EOL;
                    $html .= '                  <div class="form-group">' . PHP_EOL;
                    $html .= '                    <label for="' . $fields_table[$i] . '">' . $field_item  . ': </label>' . PHP_EOL;
                    $html .= '                    <select class="custom-select select2-box" name="' . $fields_table[$i] .'" id="' . $fields_table[$i] .'" placeholder="' . $field_item  . '">'.PHP_EOL;
                    $html .= '                      <option value="" selected disabled hidden>Seleccionar </option> '.PHP_EOL;
                    $html .= '                      <option value="text">text</option>'.PHP_EOL;
                    $html .= '                    </select>'.PHP_EOL;
                    $html .= '                  </div>' . PHP_EOL;
                    $html .= '                </div>' . PHP_EOL;
                    $html .= '' . PHP_EOL;
                  }
                  else{
                    $html .= '                <div class="col-md-12">' . PHP_EOL;
                    $html .= '                  <div class="form-group">' . PHP_EOL;
                    $html .= '                    <label for="' . $fields_table[$i] . '">' . $field_item  . ': </label>' . PHP_EOL;
                    // $html .= '                    <input type="' . $tipo_inputs[$i] .'" class="form-control" name="' . $fields_table[$i] .'" id="' . $fields_table[$i] .'" placeholder="' . $field_item  .'" value="{{ $'. $table_name .'->'.$fields_table[$i].' }}" >' . PHP_EOL;
                    $html .= '                    <input type="' . $tipo_inputs[$i] .'" class="form-control  @error(\'' . $fields_table[$i] .'\') is-invalid @enderror" name="' . $fields_table[$i] .'" id="' . $fields_table[$i] .'" placeholder="' . $field_item  .'" value="{{ old(\'' . $fields_table[$i] .'\', $'. $table_name .'->'.$fields_table[$i].' ?? \'\') }}" >' . PHP_EOL;
                    $html .= '                    @error(\'' . $fields_table[$i] .'\')' . PHP_EOL;
                    $html .= '                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>' . PHP_EOL;
                    $html .= '                    @enderror' . PHP_EOL;
                    $html .= '                  </div>' . PHP_EOL;
                    $html .= '                </div>' . PHP_EOL;
                    $html .= '' . PHP_EOL;
                  }

                }

              }

              // elseif(strpos(strtolower($fields_table[$i]), "publicar") )
              if(in_array("publicar", $fields_table) || in_array($prefix."publicar", $fields_table))
              {
                $name_publicar = (in_array("publicar", $fields_table) ) ? 'publicar' : $prefix."publicar" ;

                $html .= '                <div class="col-md-12">'.PHP_EOL;
                $html .= '                  <div class="form-group">'.PHP_EOL;
                $html .= '                    <label for="email" class="d-block">Publicar </label>'.PHP_EOL;
                $html .= '                    <div class="form-check form-check-inline">'.PHP_EOL;
                $html .= '                      <input class="form-check-input" type="radio" name="'. $name_publicar .'" id="si" value="S" <?php echo $si; ?> >'.PHP_EOL;
                $html .= '                      <label class="form-check-label" for="si">SI</label>'.PHP_EOL;
                $html .= '                    </div>'.PHP_EOL;
                $html .= '                    <div class="form-check form-check-inline">'.PHP_EOL;
                $html .= '                      <input class="form-check-input" type="radio" name="'. $name_publicar .'" id="no" value="N" <?php echo $no; ?> >'.PHP_EOL;
                $html .= '                      <label class="form-check-label" for="no">NO</label>'.PHP_EOL;
                $html .= '                    </div>'.PHP_EOL;
                $html .= '                  </div>'.PHP_EOL;
                $html .= '                </div>'.PHP_EOL;
                $html .= '' . PHP_EOL;

              }

              if(in_array("imagen", $fields_table) || in_array($prefix."imagen", $fields_table))
              {
                  $name_file_imagen = (in_array("imagen", $fields_table) ) ? 'imagen' : $prefix."imagen" ;


                  $html .= '                <div class="col-md-12 text-center">' . PHP_EOL ;
                  $html .= '                  <input type="hidden" class="form-control" name="img_bd" id="img_bd" value="{{ $'. $table_name .'->'.$name_file_imagen.' }}">' . PHP_EOL ;

                  $html .= '                  @if(!empty($'. $table_name .'->'.$name_file_imagen.'))' . PHP_EOL ;
                  $html .= '                  <img src="{{ url($'. $table_name .'->'.$name_file_imagen.') }}" class="img-fluid img-view-edit mb-2">' . PHP_EOL ;
                  $html .= '                  <hr>' . PHP_EOL ;
                  $html .= '                  @endif' . PHP_EOL ;

                  $html .= '                </div>' . PHP_EOL ;
                  $html .= '                <div class="col-12 mb-3">' . PHP_EOL ;
                  $html .= '                  <div class="form-group">' . PHP_EOL ;
                  $html .= '                    <div class="input-group mb-2">' . PHP_EOL ;
                  $html .= '                      <div class="input-group-prepend">' . PHP_EOL ;
                  $html .= '                        <label class="input-group-text" for="'.$name_file_imagen.'">Nueva Imagen</label>' . PHP_EOL ;
                  $html .= '                      </div>' . PHP_EOL ;
                  $html .= '                      <input data-file-img="images" data-id="preview-images-id" type="file" class="form-control" name="'.$name_file_imagen.'" id="'.$name_file_imagen.'" placeholder="Imagen" accept="image/*">' . PHP_EOL ;
                  $html .= '                    </div>' . PHP_EOL ;
                  $html .= '                  </div>' . PHP_EOL ;
                  $html .= '                </div>' . PHP_EOL ;
                  $html .= '' . PHP_EOL ;
                  $html .= '                <div class="col-12 mb-3">' . PHP_EOL ;
                  $html .= '                  <div class="preview-img" data-img-preview="preview-images-id"></div>' . PHP_EOL ;
                  $html .= '                </div>' . PHP_EOL;

              }


              $html .= '
              </div>

              <div class="w-100 text-center">

                <a href="{{ route(\''.$GLOBALS["prefix_route"].'.'.$table_plural.'\') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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


@section(\'script\')

  @include(\'shared.jquery-validation\')

@endsection';

return $html ;
}