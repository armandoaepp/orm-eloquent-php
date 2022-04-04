<?php
// $plural = Str::plural('child', 2);
use Illuminate\Support\Str;

function generateController($table_name, $class_name, $entities = array() )
{
  $prefix =  generatePrefixTable( $table_name ) ;
  $prefix = !empty($prefix) ? $prefix."_" : "" ;

  $table_amigable_sin_guion = str_replace ('-', ' ', $table_name);
  // $table_plural = Str::plural($table_amigable_sin_guion) ;
  $table_plural = Str::plural($table_amigable_sin_guion) ;

  $url_friendly_plural = str_replace (' ', '-', $table_plural);

  // field columns($entities);
  $fields_col = array_column($entities, 'Field');

  $class_controller = $class_name.'Controller' ;

  $folder   = CONTROLLERS;

  $file_name = $folder.$class_controller ;

  $ext = ".php" ;
  $file_open = fopen($file_name . $ext, "w");

  $str = '';
  $str .= '<?php'.PHP_EOL;
  $str .= 'namespace App\Controllers;'.PHP_EOL;
  $str .= ''.PHP_EOL;
  $str .= '/**'.PHP_EOL;
  $str .= '  * [Class Controller]'.PHP_EOL;
  $str .= '  * Autor: Armando Pisfil'.PHP_EOL;
  $str .= '  * twitter: @armandoaepp'.PHP_EOL;
  $str .= '  * email: armandoaepp@gmail.com'.PHP_EOL;
  $str .= '*/'. PHP_EOL ;
  $str .= ''. PHP_EOL ;

  $str .= 'use App\Models\\'.$class_name.'; '. PHP_EOL ;

  $str .= 'use App\Traits\BitacoraTrait;'. PHP_EOL ;
  $str .= 'use App\Traits\UploadFiles;'. PHP_EOL ;

  $str .= ''. PHP_EOL ;
  $str .= 'class '.$class_controller.''. PHP_EOL ;
  $str .= '{'. PHP_EOL ;
  $str .= '  use BitacoraTrait, UploadFiles;'. PHP_EOL ;
  $str .= ''. PHP_EOL ;
  $str .= '  protected $prefixView = "admin";'. PHP_EOL ;
  $str .= ''. PHP_EOL ;
  $str .= '  public function __construct()'. PHP_EOL ;
  $str .= '  {'. PHP_EOL  ;
  $str .= '    $this->middleware(\'auth\');'. PHP_EOL ;
  $str .= '  }'. PHP_EOL  ;


  $str .=  index($table_name, $class_name, $entities);
  $str .=  listTable($table_name, $class_name, $entities);
  $str .=  create($table_name, $class_name, $entities);
  $str .=  store($table_name, $class_name, $entities, $prefix, $url_friendly_plural);
  $str .=  edit($table_name, $class_name, $entities);
  $str .=  update($table_name, $class_name, $entities,$prefix, $url_friendly_plural);
  $str .=  delete($table_name, $class_name, $entities, $prefix);
  $str .=  destroy($table_name, $class_name, $entities, $prefix);


  /*if ( in_array('estado', $fields_col) || in_array($prefix.'estado', $fields_col))
  {
    $str .=  updateStatus($table_name, $class_name, $entities);
    $str .=  getByStatus($table_name, $class_name, $entities);
  }*/

  if ( in_array('publicar', $fields_col) || in_array($prefix.'publicar', $fields_col) )
  {
    $field_publicar = (in_array("publicar", $fields_col) ) ? 'publicar' : $prefix."publicar" ;

    $str .=  updatePublish($table_name, $class_name, $entities, $field_publicar);
    $str .=  getPublished($table_name, $class_name, $entities, $field_publicar);
  }

  $str .=  find($table_name, $class_name, $entities, $prefix);

  $str .= '}';

  fwrite($file_open, $str);
  fclose($file_open);
  return "Class Controllers Generation OK";

}

