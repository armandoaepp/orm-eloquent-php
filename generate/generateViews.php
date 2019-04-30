<?php


include 'views/list.php' ;
include 'views/newView.php' ;
include 'views/editView.php' ;

function generateView($table_name, $class_name, $entities = array(), $fields_table, $heads_table = array() , $tipo_inputs = array() )
{
  $table_amigable = App\Helpers\UrlHelper::urlFriendly($table_name);
  $table_plural = str_plural($table_amigable) ;

  $fields_col = array_column($entities, 'Field');

  // $class_controller = $table_amigable ;

  $folder   = '';

  if (file_exists(VIEWS."/" . $table_amigable)) {
    $folder = VIEWS."/" . $table_amigable . "/";
  } else {
      mkdir(VIEWS."/" . $table_amigable, 0777);
      $folder = VIEWS."/" . $table_amigable . "/";
  }

  $ext = ".php" ;

  /*  GENERATE VIEW LIST */
  $file_name_list = $folder."list-".$table_amigable ;

  $file_open = fopen($file_name_list . $ext, "w");

  $str = '';
  $str .= '';
  $str .= generateIndex($table_name, $class_name, $entities, $fields_table, $heads_table , $tipo_inputs ) ;

  fwrite($file_open, $str);
  fclose($file_open);

  echo "View List Generation OK <br> " ;

  /*  GENERATE VIEW NEW */
  $file_name_new = $folder."new-".$table_amigable ;

  $file_open = fopen($file_name_new . $ext, "w");

  $str = '';
  $str .= '';
  $str .= generateNewView($table_name, $class_name, $entities, $fields_table, $heads_table , $tipo_inputs ) ;

  fwrite($file_open, $str);
  fclose($file_open);

  echo "View New Generation OK <br> " ;


  /*  GENERATE VIEW edit */
  $file_name_edit = $folder."edit-".$table_amigable ;

  $file_open = fopen($file_name_edit . $ext, "w");

  $str = '';
  $str .= '';
  $str .= generateEditView($table_name, $class_name, $entities, $fields_table, $heads_table , $tipo_inputs ) ;

  fwrite($file_open, $str);
  fclose($file_open);

  echo "View New Generation OK <br> " ;

  return "View List Generation OK";

}


