<?php

function generateController($table_name, $class_name, $entities = array() )
{
  // var_dump($entities);
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
  $str .= '  * Autor: Armando E. Pisfil Puemape'.PHP_EOL;
  $str .= '  * twitter: @armandoaepp'.PHP_EOL;
  $str .= '  * email: armandoaepp@gmail.com'.PHP_EOL;
  $str .= '*/'. PHP_EOL ;
  $str .= ''. PHP_EOL ;

  $str .= 'use App\Models\\'.$class_name.'; '. PHP_EOL ;

  $str .= 'use App\Traits\BitacoraTrait;'. PHP_EOL ;

  $str .= ''. PHP_EOL ;
  $str .= 'class '.$class_controller.''. PHP_EOL ;
  $str .= '{'. PHP_EOL ;
  $str .= '  use BitacoraTrait;'. PHP_EOL ;
  $str .= ''. PHP_EOL ;  
  $str .= '  public function __construct()'. PHP_EOL ;
  $str .= '  {'. PHP_EOL  ;
  $str .= '    $this->middleware(\'auth\');'. PHP_EOL ;
  $str .= '  }'. PHP_EOL  ;


  $str .=  getAll($table_name, $class_name, $entities);
  $str .=  newRegister($table_name, $class_name, $entities);
  $str .=  save($table_name, $class_name, $entities);
  $str .=  edit($table_name, $class_name, $entities);
  $str .=  update($table_name, $class_name, $entities);
  $str .=  delete($table_name, $class_name, $entities);
  $str .=  find($table_name, $class_name, $entities);

  if ( in_array('estado', $fields_col) )
  {
    $str .=  updateStatus($table_name, $class_name, $entities);
    $str .=  getByStatus($table_name, $class_name, $entities);
  }

  if ( in_array('publish', $fields_col) )
  {
    $str .=  updatePublish($table_name, $class_name, $entities);
    $str .=  getPublished($table_name, $class_name, $entities);
  }

  $str .= '}';

  fwrite($file_open, $str);
  fclose($file_open);
  return "Class Controllers Generation OK";

}

