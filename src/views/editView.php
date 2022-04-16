<?php
use Illuminate\Support\Str;

function generateEditView($table_name, $class_name, $entities = array(), $fields_table, $heads_table = array() , $tipo_inputs = array() )
{
  $table_amigable = App\Helpers\UrlHelper::urlFriendly($table_name);
  $table_amigable_sin_guion = str_replace ('-', ' ', $table_amigable);

  $table_plural = Str::plural($table_amigable_sin_guion) ;

  $table_friendly_plural = str_replace (' ', '-', $table_plural);
  // $title = ucwords(str_replace ('-', ' ', $title_lower));
  $title = ucwords($table_plural);

  $prefix =  generatePrefixTable( $table_name ) ;
  $prefix = !empty($prefix) ? $prefix."_" : "" ;

$html = '';
$html .= '@php
  $sidebar = array(
    "sidebar_active" => [0, 0],
  );
@endphp
' ;

/* if(in_array("publicar", $fields_table) || in_array($prefix."publicar", $fields_table))
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

} */

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
      <a href="{{ route(\''.$GLOBALS["prefix_route"].'.'.$table_friendly_plural.'\') }}" class="">
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
            @include(\'admin.'.$table_friendly_plural.'.form-edit-'.$table_name.'\')
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<!-- end:: Content -->

@endsection


@section(\'script\')

@endsection';

return $html ;
}