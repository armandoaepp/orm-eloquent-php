<?php
use Illuminate\Support\Str;


function generateIndex($table_name, $class_name, $entities = array(), $fields_table, $heads_table = array() , $tipo_inputs = array() )
{
  $table_amigable = App\Helpers\UrlHelper::urlFriendly($table_name);

  $table_sin_guion = str_replace ('-', ' ', $table_amigable);

  $table_plural = Str::plural($table_amigable) ;
  $title = ucwords(str_replace ('-', ' ', $table_plural));

  $prefix =  generatePrefixTable( $table_name ) ;
  $prefix = !empty($prefix) ? $prefix."_" : "" ;

  // field columns($entities);
  $fields_col = array_column($entities, 'Field');

$html = '@php
  $sidebar = array(
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
      <a href="#" data-reload="list-table" data-href="{{ route(\''.$GLOBALS["prefix_route"].'.'.$table_plural.'\') }}" class="btn btn-outline-primary btn-sm" type="button">
        <i class="fas fa-list-ul"></i>
        Listar
      </a>
      <a href="#" id="btn-create" data-href="{{ route(\''.$GLOBALS["prefix_route"].'.'.$table_plural.'.create\') }}" class="btn btn-outline-primary btn-sm" type="button">
        <i class="fas fa-file"></i>
        Nuevo
      </a>
    </div>

    <div class="col-12">
      <div class="card">
        <div class="card-header bg-white">
          <i class="fa fa-align-justify"></i> Lista de '.$table_plural.'
        </div>
        <div class="card-body">
         <div id="wrap-table" class="table-responsive">
           @include(\'admin.'.$table_plural.'.list-table-'.$table_plural.'\')
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<!-- end:: Content -->
@endsection

<!-- Start:: Section modal  -->
@section(\'modal\')
  <x-modals.modal-create title="Nuevo '.ucwords($table_name).'">
  {{-- @include(\''.$GLOBALS["prefix_route"].'.'.$table_plural.'.form-create-'.$table_name.'\') --}}
  </x-modals.modal-create>

  <x-modals.modal-edit title="Editar '.ucwords($table_name).'" />

  <x-forms.form-post form-id="form-delete" url="{{ route(\''.$GLOBALS["prefix_route"].'.'.$table_plural.'.delete\') }}" class="d-none" />
  <x-forms.form-destroy table="'.ucwords($table_amigable).'" url="{{ route(\''.$GLOBALS["prefix_route"].'.'.$table_plural.'.destroy\') }}" />' ;
$html .= '  '. PHP_EOL;

if(in_array("publicar", $fields_table) || in_array($prefix."publicar", $fields_table))
{
  $html .= '  <x-forms.form-publish url="{{ route(\''.$GLOBALS["prefix_route"].'.'.$table_plural.'.publish\') }}" /> '. PHP_EOL;
}
// $html .= '  '. PHP_EOL;

$html .= '@endsection

<!-- Start:: Section script  -->
@section(\'script\')

  @include(\'shared.datatables\')

  <script src="{{ asset(\'assets/js/app-admin.js\') }}"></script>
' . PHP_EOL ;
$html .= '@endsection';

return $html ;
}