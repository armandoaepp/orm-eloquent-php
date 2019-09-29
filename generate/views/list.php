<?php
function generateIndex($table_name, $class_name, $entities = array(), $fields_table, $heads_table = array() , $tipo_inputs = array() )
{
  $table_amigable = App\Helpers\UrlHelper::urlFriendly($table_name);

  $table_sin_guion = str_replace ('-', ' ', $table_amigable);

  $table_plural = str_plural($table_amigable) ;
  $title = ucwords(str_replace ('-', ' ', $table_plural));

  $prefix =  generatePrefixTable( $table_name ) ;
  $prefix = !empty($prefix) ? $prefix."_" : "" ;

  // field columns($entities);
  $fields_col = array_column($entities, 'Field');

$html = '
<?php
  $sidebar = array(
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );

?>

@extends(\'layouts.app-admin\')

@section(\'content\')

<nav class="full-content" aria-label="breadcrumb">
  <ol class="breadcrumb breadcrumb-shape breadcrumb-theme shadow-sm radius-0">
    <li class="breadcrumb-item">
      <a href="{{ route(\'admin\') }}">
        <i class="fas fa-home"></i> Home
      </a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">
      <span>
      '.$title.'
      </span>
    </li>
  </ol>
</nav>

<!-- begin:: Content -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12 mb-3">
      <a href="{{ route(\'admin-'.$table_plural.'\') }}" class="btn btn-outline-secondary btn-sm btn-bar" role="button">
        <i class="fas fa-list-ul"></i>
        Listar
      </a>
      <a href="{{ route(\''.$table_amigable.'-create\') }}" class="btn btn-outline-secondary btn-sm btn-bar" role="button">
        <i class="fas fa-file"></i>
        Nuevo
      </a>
    </div>

    <?php
      $status = [
        "0" => ["title" => "Eliminado", "class" => " badge-danger"],
        "1" => ["title" => "Activo", "class" => " badge-success"],
      ];
    ?>

    <div class="col-12">
      <div class="card">
        <div class="card-header bg-white">
          <i class="fa fa-align-justify"></i> Lista de '.$table_plural.'
        </div>
        <div class="card-body">
          <!-- <div class="table-responsive"> -->

          <!--begin: Datatable -->
          <table id="dataTableLists" class="table table-sm table-hover table-bordered dt-responsive nowrap" style="width: 100%;">
            <thead>
              <tr>' . PHP_EOL;
              for ($i=0; $i < count( $heads_table) ; $i++)
              {
                if ( !verificarItemNotListTable($fields_table[$i], $prefix) )
                {
                  $width = '' ;
                  if ($i == 0) {
                    $width = ' width="60"' ;
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

    $html .= '                <th width="80"> Publicado </th>' . PHP_EOL ;
    if(in_array("publicar", $fields_table) || in_array($prefix."publicar", $fields_table))
    {
      $html .= '                <th width="80"> Estado </th>' . PHP_EOL ;
    }

    $html .= '                <th width="50"> Acciones </th>' . PHP_EOL ;

    $html .= '              </tr>
            </thead>
            <tbody>

            @foreach ($data as $row)

            <?php

              /* publicar */
              $classBtn = "" ;
              $title    = "" ;
              $icon_pub = "" ;
              $publicado = "";

              if(!empty($row->'.$prefix_publicar.')){
                if($row->'.$prefix_publicar.' == "S"){
                  $classBtn =  "btn-outline-danger";
                  $title = "Desactivar/Ocultar" ;
                  $icon_pub = \'<i class="fas fa-times"></i>\';
                  $publicado = \'<span class="badge badge-pill badge-success"> SI </span>\';
                }
                else {
                  $classBtn =  "btn-outline-success";
                  $title = "Publicar" ;
                  $icon_pub = \'<i class="fas fa-check"></i>\';
                  $publicado = \'<span class="badge badge-pill badge-danger"> NO </span>\';
                }
              }

              /* estado */
              $title_estado = "";
              $class_estado = "";
              $class_disabled = "";

              if ($row->'.$prefix_estado.' == 0) {
                $title_estado = "Recuperar";
                $class_estado = "row-disabled";
                $class_disabled = "disabled";
              } else {
                $title_estado = "Eliminar";
              }


            ?>

              <tr class="<?php echo $class_estado; ?>">'. PHP_EOL;

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
                $html .= '                  <?php echo $publicado; ?>'. PHP_EOL;
                $html .= '                </td>'. PHP_EOL;
              }


              $html .= '                <td class="text-center">'. PHP_EOL;
              $html .= '                  <span class="badge badge-pill <?php echo $status[$row->'.$prefix_estado.']["class"] ?>"> '. PHP_EOL;
              $html .= '                    <?php echo $status[$row->'.$prefix_estado.']["title"] ?> '. PHP_EOL;
              $html .= '                  </span>'. PHP_EOL;
              $html .= '                </td>'. PHP_EOL;

              $html .= '                <td class="text-center">'. PHP_EOL;
              $html .='                  <div class="dropdown">' .PHP_EOL ;
              $html .='                    <button class="btn btn-outline-primary btn-sm lh-1 btn-table dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' .PHP_EOL ;
              $html .='                        <i class="fas fa-ellipsis-h"></i>' .PHP_EOL ;
              $html .='                    </button>' .PHP_EOL ;
              $html .='                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">' .PHP_EOL ;
              $html .='                      <a class="dropdown-item <?php echo $class_disabled; ?>" href="{{ route(\''.$table_amigable.'-edit\',[\'id\' => $row->'.$fields_table[0].']) }}" >' .PHP_EOL ;
              $html .='                        <i class="far fa-edit"></i> Editar' .PHP_EOL ;
              $html .='                      </a>' .PHP_EOL ;
              $html .='                      <a class="dropdown-item item-delete" href="#" data-id="{{ $row->'.$fields_table[0].' }}" data-descripcion="{{ $row->'.$fields_table[1].' }}" data-title="<?php echo $title_estado ?>" data-estado="{{ $row->'.$prefix_estado.' }}" title="<?php echo $title_estado; ?>" >' .PHP_EOL ;
              $html .='                        <i class="far fa-trash-alt"></i> <?php echo $title_estado; ?>' .PHP_EOL ;
              $html .='                      </a>' .PHP_EOL ;

              if(in_array("publicar", $fields_table) || in_array($prefix."publicar", $fields_table))
              {
                $name_publicar = (in_array("publicar", $fields_table) ) ? 'publicar' : $prefix."publicar" ;
                $html .='                      <a class="dropdown-item item-publish <?php echo $class_disabled; ?>" href="#" data-id="{{ $row->'.$fields_table[0].' }}" data-descripcion="{{ $row->'.$fields_table[1].' }}" data-title="<?php echo $title ?>" data-publish="{{ $row->'.$name_publicar.' }}" title="<?php echo $title; ?>" >' .PHP_EOL ;
                $html .='                        <?php echo $icon_pub ;?> <?php echo $title; ?>' .PHP_EOL ;
                $html .='                      </a>' .PHP_EOL ;
              }
              $html .='                    </div>' .PHP_EOL ;
              $html .='                  </div>' .PHP_EOL ;
              $html .= '                </td>'. PHP_EOL;

              /*if(in_array("publicar", $fields_table) || in_array($prefix."publicar", $fields_table))
              {
                $name_publicar = (in_array("publicar", $fields_table) ) ? 'publicar' : $prefix."publicar" ;

                $html .= '                <td class="text-center">' . PHP_EOL;
                $html .= '                 <span class="sr-only"><?php echo $row->'. $name_publicar .'; ?></span>' . PHP_EOL;
                $html .= '                 <button onclick="modalPublicar(event, <?php echo $row->'. $fields_table[0] .' ?>, `<?php echo $row->'. $fields_table[1] .' ?>` ,`<?php echo $title ?>`, `<?php echo $row->'. $name_publicar .';  ?>`);" class="btn btn-sm lh-1 btn-table <?php echo $classBtn.\' \' .$class_disabled; ; ?> " title="<?php echo $title; ?>" >' . PHP_EOL;
                $html .= '                   <?php echo $icon_pub ;?>' . PHP_EOL;
                $html .= '                 </button>' . PHP_EOL;
                $html .= '                </td>' . PHP_EOL;
              }*/


            /*$html .= '
                <td nowrap>
                  <a class="btn btn-outline-primary btn-sm lh-1 btn-table <?php echo $class_disabled; ?>" href="{{ route(\''.$table_amigable.'-edit\',[\'id\' => $row->'.$fields_table[0].']) }}" title="Editar">
                    <i class="fas fa-pencil-alt"></i>
                  </a>
                  <button class="btn btn-outline-danger btn-sm lh-1 btn-table" onclick="modalDelete(event,{{$row->'.$fields_table[0].'}}, `{{$row->'.$fields_table[1].'}}`,`<?php echo $title_estado ?>`,`{{$row->'.$prefix_estado.'}}`);" title="<?php echo $title_estado; ?>">
                    <i class="far fa-trash-alt"></i>
                  </button>
                  <span class="sr-only">
                    {{ $row->'.$prefix_estado.' }}
                  </span>
                </td>'.PHP_EOL ;*/
          $html .= '
              </tr>
            @endforeach
            </tbody>
          </table>
          <!--end: Datatable -->


          <!-- </div> -->
        </div>
      </div>
    </div>

  </div>

</div>

<!-- end:: Content -->
@endsection

<!-- Start:: Section modal  -->
@section(\'modal\')

  @include(\'shared.form-modal-delete\', [\'url\' => route(\''.$table_amigable.'-delete\') ])

  @include(\'shared.form-modal-publicar\' , [\'url_publish\' => route(\''.$table_amigable.'-publish\') ])

@endsection

<!-- Start:: Section script  -->
@section(\'script\')

  @include(\'shared.datatables\')

  <script src="{{ asset(\'assets/js/app-form.js\') }}"></script>
' . PHP_EOL ;
if ( in_array('publicar', $fields_col) || in_array($prefix.'publicar', $fields_col) )
{
  // $html .= '' . PHP_EOL ;
}

$html .= '@endsection';

return $html ;
}