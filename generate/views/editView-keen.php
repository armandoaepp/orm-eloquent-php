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
    "sidebar_class" => "",
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );

?>

@extends(\'layouts.app-admin\')

@section(\'content\')

<div class="kt-subheader   kt-grid__item" id="kt_subheader">
  <div class="kt-subheader__main">
    <h3 class="kt-subheader__title"> '.$title.'</h3>
    <span class="kt-subheader__separator kt-hidden"></span>
    <div class="kt-subheader__breadcrumbs">
      <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
      <span class="kt-subheader__breadcrumbs-separator"></span>
      <a href="#" class="kt-subheader__breadcrumbs-link">
        Maestros </a>
      <span class="kt-subheader__breadcrumbs-separator"></span>
      <a href="{{ route(\'admin-'.$table_plural.'\') }}" class="kt-subheader__breadcrumbs-link">
      '.ucwords($table_amigable_no_guion).'
      </a>
    </div>
  </div>
</div>

<!-- begin:: Content -->
<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
  <!-- begin:: Data List -->
  <div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head">
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">
          Editar '.ucwords($table_amigable_no_guion).'
        </h3>
      </div>
    </div>
    <div class="kt-portlet__body position-relative">

        <div class="col-12">
          <form action="{{  route(\''.$table_amigable_no_guion.'-update\') }}" method="POST" enctype="multipart/form-data">
            @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $data->'.$fields_table[0].' }}">
              <div class="row">' . PHP_EOL;

              for ($i=0; $i < count( $fields_table) ; $i++)
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

                // $html .= '
                //   <div class="col-md-12">
                //     <div class="form-group">
                //       <label for="'.$fields_table[$i].'">'.$fields_table[$i].': </label>
                //       <input type="text" class="form-control" name="'.$fields_table[$i].'" id="'.$fields_table[$i].'" placeholder="'.$fields_table[$i].'"
                //         value="">
                //     </div>
                //   </div>
                //   ';
              }


              $html .= '


              </div>

            <div class="w-100 text-center">

                  <a href="{{ route(\'admin-'.$table_plural.'\') }}" class="btn btn-danger btn-elevate btn-elevate-air"> <i class="fas fa-ban"></i>
                  Cancelar</a>
                <button type="submit" class="btn btn-brand btn-elevate btn-elevate-air"> <i class="fas fa-save"></i>
                  Guardar</button>
            </div>

          </form>
        </div>

    </div>
  </div>

  <!-- end:: Data List -->

</div>
<!-- end:: Content -->


@endsection


@section(\'script\')


@endsection
';

return $html ;
}