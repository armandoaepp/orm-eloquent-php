<?php

include 'views/list.php' ;

function generateView($table_name, $class_name, $entities = array() )
{
  $table_amigable = App\Helpers\UrlHelper::urlFriendly($table_name);
  $table_plural = str_plural($table_amigable) ;

  $fields_col = array_column($entities, 'Field');

  // $class_controller = $table_amigable ;

  $folder   = VIEWS;

  $file_name = $folder."list-".$table_amigable ;

  $ext = ".php" ;
  $file_open = fopen($file_name . $ext, "w");


  $str = '';
  $str .= '';
  $str      .= generateIndex($table_name, $class_name, $entities) ;

  fwrite($file_open, $str);
  fclose($file_open);
  return "View List Generation OK";

}


