<?php
use Illuminate\Support\Str;


function generateListTable($table_name, $class_name, $entities = array(), $fields_table, $heads_table = array() , $tipo_inputs = array() )
{
  $table_amigable = App\Helpers\UrlHelper::urlFriendly($table_name);

  $table_sin_guion = str_replace ('-', ' ', $table_amigable);

  $table_plural = Str::plural($table_amigable) ;
  $title = ucwords(str_replace ('-', ' ', $table_plural));

  $prefix =  generatePrefixTable( $table_name ) ;
  $prefix = !empty($prefix) ? $prefix."_" : "" ;

  // field columns($entities);
  $fields_col = array_column($entities, 'Field');

$html = '          <!--begin: Datatable -->
          <table id="dataTableLists" class="table table-sm table-hover table-bordered" style="width: 100%;">
            <thead>
              <tr class="bg-light text-uppercase">' . PHP_EOL;
              for ($i=0; $i < count( $heads_table) ; $i++)
              {
                if ( !verificarItemNotListTable($fields_table[$i], $prefix) )
                {
                  $width = '' ;
                  if ($i == 0) {
                    $width = ' width="50"' ;
                  }

                  // ==== Start remove prefix
                  $field_item = $heads_table[$i] ;
                  if(!empty($prefix))
                  {
                    $field_item = revemoPrefix($field_item, $prefix)  ;
                  }
                  $field_item = toCamelCase($field_item);

                  // ==== Start remove prefix

                  $html .= '                <th'.$width.'> '.$field_item .' </th> '  . PHP_EOL ;
                }
              }

    $prefix_estado = (in_array("estado", $fields_table) ) ? 'estado' : $prefix."estado" ;
    $prefix_publicar = (in_array("publicar", $fields_table) ) ? 'publicar' : $prefix."publicar" ;


    if(in_array("publicar", $fields_table) || in_array($prefix."publicar", $fields_table))
    {
      $html .= '                <th width="50" title="Publicado">Publ.</th>' . PHP_EOL ;
    }

    $html .= '                <th width="50" title="Estado">Est.</th>' . PHP_EOL ;

    $html .= '                <th width="50"> Acciones </th>' . PHP_EOL ;

    $html .= '              </tr>
            </thead>
            <tbody>

            @foreach ($data as $row)

            @php'. PHP_EOL  ;
    $html .= '              $title = $row->descripcion;';
      $html .= '
            @endphp

              <tr @if ($row->'.$prefix_estado.'== 0) class="row-disabled" @endif>'. PHP_EOL;

              for ($i=0; $i < count( $fields_table) ; $i++)
              {
                if ( !verificarItemNotListTable($fields_table[$i], $prefix) )
                {
                  if($i == 0)
                  {
                    $html .= '                <td> {{ str_pad($row->'.$fields_table[$i].', 3, "0", STR_PAD_LEFT) }} </td> '. PHP_EOL;
                  }
                  else
                  {
                    $html .= '                <td> {{ $row->'.$fields_table[$i].' }} </td> '. PHP_EOL;
                  }
                }

              }

              if(in_array("publicar", $fields_table) || in_array($prefix."publicar", $fields_table))
              {
                $name_publicar = (in_array("publicar", $fields_table) ) ? 'publicar' : $prefix."publicar" ;
                $html .= '                <td class="text-center">'. PHP_EOL;
                $html .= '                  <div class="form-check form-switch d-inline-block">'. PHP_EOL;
                $html .= '                    <input type="checkbox" onchange="publish(this);" class="switch-publish form-check-input" value="{{ $row->'.$fields_table[0].'  }}" data-publish="{{ $row->publicar }}" id="publish-{{ $loop->index }}" @if($row->publicar == \'S\') checked @endif role="switch">'. PHP_EOL;
                $html .= '                  </div>'. PHP_EOL;
                $html .= '                </td>'. PHP_EOL;
              }

              $html .= '                <td class="text-center">'. PHP_EOL;
              $html .= '                  <div class="form-check form-switch d-inline-block">'. PHP_EOL;
              $html .= '                    <input type="checkbox" onchange="desactivar(this);" class="switch-delete form-check-input" value="{{ $row->'.$fields_table[0].' }}" data-estado="{{ $row->'.$prefix_estado.' }}" id="delete-{{ $loop->index }}" @if ($row->'.$prefix_estado.' == 1) checked @endif role="switch">'. PHP_EOL;
              $html .= '                  </div>'. PHP_EOL;
              $html .= '                </td>'. PHP_EOL;

              $html .= '                <td class="text-center">'. PHP_EOL;
              $html .='                  <div class="dropdown">' .PHP_EOL ;
              $html .='                    <button class="btn btn-outline-primary btn-sm lh-1 dropdown-toggle btn-action" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' .PHP_EOL ;
              // $html .='                        <i class="fas fa-ellipsis-h"></i>' .PHP_EOL ;
              $html .='                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">' .PHP_EOL ;
              $html .='                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />' .PHP_EOL ;
              $html .='                      </svg>' .PHP_EOL ;
              $html .='                      <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">' .PHP_EOL ;
              $html .='                        <path d="M3.204 5h9.592L8 10.481 3.204 5zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z" />' .PHP_EOL ;
              $html .='                      </svg>' .PHP_EOL ;
              $html .='                    </button>' .PHP_EOL ;

              $html .='                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">' .PHP_EOL ;
              $html .='                      <a  class="dropdown-item btn-action" href="#" data-href="{{ route(\''.$GLOBALS["prefix_route"].'.'.$table_plural.'.edit\',[\'id\' => $row->'.$fields_table[0].']) }}" onclick="openModalEdit(this);event.preventDefault();" title="Editar '.$table_name.': {{ $title }}" type="button">' .PHP_EOL ;
              $html .='                        <i class="far fa-edit"></i> Editar' .PHP_EOL ;
              $html .='                      </a>' .PHP_EOL ;
              $html .='                      <a class="dropdown-item btn-action" href="#" data-href="{{ route(\''.$GLOBALS["prefix_route"].'.'.$table_plural.'.destroy\') }}" onclick="openModalDestroy(this);event.preventDefault();"  data-id="{{$row->'.$fields_table[0].'}}"   title="Borrar '.$table_name.': {{ $title }}" data-title="{{ $title }}" type="button" >' .PHP_EOL ;
              $html .='                        <i class="far fa-trash-alt"></i> Borrar Registro' .PHP_EOL ;
              $html .='                      </a>' .PHP_EOL ;
              $html .='                    </div>' .PHP_EOL ;
              $html .='                  </div>' .PHP_EOL ;
              $html .= '                </td>'. PHP_EOL;

          $html .= '
              </tr>
            @endforeach
            </tbody>
          </table>
          <!--end: Datatable -->
' . PHP_EOL ;

return $html ;
}