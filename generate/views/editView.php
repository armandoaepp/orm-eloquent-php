<?php
function generateEditView($table_name, $class_name, $entities = array(), $fields_table, $heads_table = array() , $tipo_inputs = array() )
{
  $table_amigable = App\Helpers\UrlHelper::urlFriendly($table_name);
  $table_amigable_no_guion = str_replace ('-', ' ', $table_amigable);

  $table_plural = str_plural($table_amigable_no_guion) ;

  // $title = ucwords(str_replace ('-', ' ', $title_lower));
  $title = ucwords($table_plural);

$html = '
<?php
  $sidebar = array(
    "sidebar_class"  => "",
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );

?>

@extends(\'layouts.app-admin\')

@section(\'content\')

<nav class="full-content" aria-label="breadcrumb">
  <ol class="breadcrumb breadcrumb-shape shadow-sm radius-0">
    <li class="breadcrumb-item">
      <a href="{{ route(\'admin\') }}">
        <i class="fas fa-home"></i> Home
      </a>
    </li>

    <li class="breadcrumb-item" aria-current="page">
      <a href="{{ route(\'admin-'.$table_plural.'\') }}" class="">
      '.$title.'
      </a>
    </li>

    <li class="breadcrumb-item active bg-info text-white" aria-current="page">
      <span>
      Editar '.ucwords($table_amigable_no_guion).'
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
          <i class="fa fa-align-justify"></i> Editar '.ucwords($table_amigable_no_guion).'
        </div>
        <div class="card-body">
          <div class="col-12">

            <form action="{{  route(\''.$table_amigable_no_guion.'-update\') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $data->'.$fields_table[0].' }}">
              <div class="row">' . PHP_EOL;

              for ($i=1; $i < count( $fields_table) ; $i++)
              {

                if ( !verificarItemForm($fields_table[$i]) )
                {

                  if($tipo_inputs[$i] == 'textarea')
                  {
                    $html .= '                <div class="col-md-12">' . PHP_EOL;
                    $html .= '                  <div class="form-group">' . PHP_EOL;
                    $html .= '                    <label for="' . $fields_table[$i] . '">' . toCamelCase($fields_table[$i]) . ': </label>' . PHP_EOL;
                    $html .= '                    <textarea class="form-control ckeditor" name="' . $fields_table[$i] .'" id="' . $fields_table[$i] .'" placeholder="' . toCamelCase($fields_table[$i]) . '" cols="30" rows="6">{{ $data->'.$fields_table[$i].' }}</textarea>' . PHP_EOL;
                    $html .= '                  </div>' . PHP_EOL;
                    $html .= '                </div>' . PHP_EOL;
                    $html .= '' . PHP_EOL;
                  }
                  elseif($tipo_inputs[$i] == 'select')
                  {
                    $html .= '                <div class="col-md-12">' . PHP_EOL;
                    $html .= '                  <div class="form-group">' . PHP_EOL;
                    $html .= '                    <label for="' . $fields_table[$i] . '">' . toCamelCase($fields_table[$i]) . ': </label>' . PHP_EOL;
                    $html .= '                    <select class="custom-select" name="' . $fields_table[$i] .'" id="' . $fields_table[$i] .'" placeholder="' . toCamelCase($fields_table[$i]) . '">'.PHP_EOL;
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
                    $html .= '                    <label for="' . $fields_table[$i] . '">' . toCamelCase($fields_table[$i]) . ': </label>' . PHP_EOL;
                    $html .= '                    <input type="' . $tipo_inputs[$i] .'" class="form-control" name="' . $fields_table[$i] .'" id="' . $fields_table[$i] .'" placeholder="' . toCamelCase($fields_table[$i]) .'" value="{{ $data->'.$fields_table[$i].' }}" >' . PHP_EOL;
                    $html .= '                  </div>' . PHP_EOL;
                    $html .= '                </div>' . PHP_EOL;
                    $html .= '' . PHP_EOL;
                  }

                }
              }


              $html .= '
              </div>

              <div class="w-100 text-center">

                <a href="{{ route(\'admin-'.$table_plural.'\') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a>
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


@endsection
';

return $html ;
}