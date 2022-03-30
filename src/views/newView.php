<?php
use Illuminate\Support\Str;

function generateNewView($table_name, $class_name, $entities = array(), $fields_table, $heads_table = array() , $tipo_inputs = array(), $fields_requireds = array() )
{
  $table_amigable = App\Helpers\UrlHelper::urlFriendly($table_name);
  $table_amigable_sin_guion = str_replace ('-', ' ', $table_amigable);

  $table_plural = Str::plural($table_amigable_sin_guion) ;

  $url_friendly_plural = str_replace (' ', '-', $table_plural);

  // $title = ucwords(str_replace ('-', ' ', $title_lower));
  $title = ucwords($table_plural);

  $prefix =  generatePrefixTable( $table_name ) ;
  $prefix = !empty($prefix) ? $prefix."_" : "" ;


$html = '@php
  $sidebar = array(
    "sidebar_toggle" => "only",
    "sidebar_active" => [0, 0],
  );
@endphp

@extends(\'layouts.app-admin\')

@section(\'title\')
  '.$title .'
@endsection

@section(\'content\')

<nav class="full-content" aria-label="breadcrumb">
  <ol class="breadcrumb breadcrumb-shape breadcrumb-theme shadow-sm radius-0">
    <li class="breadcrumb-item">
      <a href="{{ route(\''.$GLOBALS["prefix_route"].'\') }}">
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
      Nuevo '.ucwords($table_amigable_sin_guion).'
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
          <i class="fa fa-align-justify"></i> Nuevo '.ucwords($table_amigable_sin_guion).'
        </div>
        <div class="card-body">
          <div class="col-12">
            @include(\'admin.'.$table_plural.'.form-create-'.$table_name.'\')
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