<?php
use Illuminate\Support\Str;

function generateFormCreateView($table_name, $class_name, $entities = array(), $fields_table, $heads_table = array() , $tipo_inputs = array(), $fields_requireds = array() )
{
  $table_amigable = App\Helpers\UrlHelper::urlFriendly($table_name);
  $table_amigable_sin_guion = str_replace ('-', ' ', $table_amigable);

  $table_plural = Str::plural($table_amigable_sin_guion) ;

  $table_friendly_plural = str_replace (' ', '-', $table_plural);

  // $title = ucwords(str_replace ('-', ' ', $title_lower));
  $title = ucwords($table_plural);

  $prefix =  generatePrefixTable( $table_name ) ;
  $prefix = !empty($prefix) ? $prefix."_" : "" ;


$html = '            <form id="form-create" action="{{  route(\''.$GLOBALS["prefix_route"].'.'.$table_friendly_plural.'.store\') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="">
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

                  $required = in_array($fields_table[$i], $fields_requireds ) ? 'required' : '';

                  if($tipo_inputs[$i] == 'textarea')
                  {
                    $html .= '                <div class="col-md-12 mb-2">' . PHP_EOL;
                    $html .= '                  <div class="form-group">' . PHP_EOL;
                    $html .= '                    <label for="' . $fields_table[$i] . '">' . $field_item  . ': </label>' . PHP_EOL;
                    $html .= '                    <textarea class="form-control ckeditor @error(\'' . $fields_table[$i] .'\') is-invalid @enderror" name="' . $fields_table[$i] .'" id="' . $fields_table[$i] .'" placeholder="' . $field_item . '" cols="30" rows="4">{{ old(\'' . $fields_table[$i] .'\') }}</textarea>' . PHP_EOL;
                    $html .= '                    @error(\'' . $fields_table[$i] .'\')' . PHP_EOL;
                    $html .= '                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>' . PHP_EOL;
                    $html .= '                    @enderror' . PHP_EOL;
                    $html .= '                  </div>' . PHP_EOL;
                    $html .= '                </div>' . PHP_EOL;
                    $html .= '' . PHP_EOL;
                  }
                  elseif($tipo_inputs[$i] == 'select')
                  {
                    $html .= '                <div class="col-md-12 mb-2">' . PHP_EOL;
                    $html .= '                  <div class="form-group">' . PHP_EOL;
                    $html .= '                    <label for="' . $fields_table[$i] . '">' . $field_item . ': </label>' . PHP_EOL;
                    $html .= '                    <select class="form-select select2-box" name="' . $fields_table[$i] .'" id="' . $fields_table[$i] .'" placeholder="' . $field_item . '">'.PHP_EOL;
                    $html .= '                      <option value="" selected disabled hidden>Seleccionar </option> '.PHP_EOL;
                    $html .= '                      <option value="text">text</option>'.PHP_EOL;
                    $html .= '                    </select>'.PHP_EOL;
                    $html .= '                  </div>' . PHP_EOL;
                    $html .= '                </div>' . PHP_EOL;
                    $html .= '' . PHP_EOL;
                  }
                  else
                  {
                    $html .= '                <div class="col-md-12 mb-2">' . PHP_EOL;
                    $html .= '                  <div class="form-group">' . PHP_EOL;
                    $html .= '                    <label for="' . $fields_table[$i] . '">' . $field_item  . ': </label>' . PHP_EOL;
                    // $html .= '                    <input type="' . $tipo_inputs[$i] .'" class="form-control @error(\'' . $fields_table[$i] .'\') is-invalid @enderror" name="' . $fields_table[$i] .'" id="' . $fields_table[$i] .'" value="{{ old(\'' . $fields_table[$i] .'\') }}" placeholder="' . $field_item  .'">' . PHP_EOL;
                    $html .= '                    <input type="' . $tipo_inputs[$i] .'" class="form-control @error(\'' . $fields_table[$i] .'\') is-invalid @enderror" name="' . $fields_table[$i] .'" id="' . $fields_table[$i] .'" value="{{ old(\'' . $fields_table[$i] .'\') }}" '. $required .' placeholder="' . $field_item  .'">' . PHP_EOL;
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

                $html .= '                <div class="col-md-12 mb-2">'.PHP_EOL;
                $html .= '                  <div class="form-group">'.PHP_EOL;
                $html .= '                    <label for="email" class="d-block">Publicar </label>'.PHP_EOL;
                $html .= '                    <div class="form-check form-check-inline">'.PHP_EOL;
                $html .= '                      <input class="form-check-input" type="radio" name="'. $name_publicar .'" id="si" value="S" checked="checked">'.PHP_EOL;
                $html .= '                      <label class="form-check-label" for="si">SI</label>'.PHP_EOL;
                $html .= '                    </div>'.PHP_EOL;
                $html .= '                    <div class="form-check form-check-inline">'.PHP_EOL;
                $html .= '                      <input class="form-check-input" type="radio" name="'. $name_publicar .'" id="no" value="N">'.PHP_EOL;
                $html .= '                      <label class="form-check-label" for="no">NO</label>'.PHP_EOL;
                $html .= '                    </div>'.PHP_EOL;
                $html .= '                  </div>'.PHP_EOL;
                $html .= '                </div>'.PHP_EOL;
                $html .= '' . PHP_EOL;

              }

              if(in_array("imagen", $fields_table) || in_array($prefix."imagen", $fields_table))
              {
                  $name_file_imagen = (in_array("imagen", $fields_table) ) ? 'imagen' : $prefix."imagen" ;

                  $html .= '                <div class="col-12 mb-2">' . PHP_EOL;
                  $html .= '                  <div class="form-group">' . PHP_EOL;
                  $html .= '                    <label for="'. $name_file_imagen. '">Imagen:</label>' . PHP_EOL;
                  $html .= '                    <input data-file-img="images" data-id="preview-images-id" type="file" class="form-control" name="'. $name_file_imagen. '" id="'. $name_file_imagen. '" required placeholder="Imagen" accept="image/*" onchange="imagesPreview(this)">' . PHP_EOL;
                  $html .= '                  </div>' . PHP_EOL;
                  $html .= '                </div>' . PHP_EOL;
                  $html .= '' . PHP_EOL;
                  $html .= '                <div class="col-12 mb-3">' . PHP_EOL;
                  $html .= '                  <div class="preview-img" data-img-preview="preview-images-id"></div>' . PHP_EOL;
                  $html .= '                </div>' . PHP_EOL;

              }


              $html .= '
              </div>

              <div class="w-100 text-center">
                {{--  <a href="{{ route(\''.$GLOBALS["prefix_route"].'.'.$table_friendly_plural.'\') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form>';

return $html ;
}