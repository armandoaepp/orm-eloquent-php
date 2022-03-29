<?php

use Illuminate\Support\Str;

include 'views/list.php' ;
include 'views/newView.php' ;
include 'views/editView.php' ;
include 'views/list-table.php' ;
include 'views/formCreateView.php' ;
include 'views/formEditView.php' ;

function generateView($table_name, $class_name, $entities = array(), $fields_table, $heads_table = array() , $tipo_inputs = array(), $fields_requireds = array())
{
  $table_amigable = App\Helpers\UrlHelper::urlFriendly($table_name);
  $table_plural = Str::plural($table_amigable) ;

  $fields_col = array_column($entities, 'Field');

  // $class_controller = $table_amigable ;

  $folder   = '';

  if (file_exists(VIEWS."/" . $table_plural)) {
    $folder = VIEWS."/" . $table_plural . "/";
  } else {
      mkdir(VIEWS."/" . $table_plural, 0777);
      $folder = VIEWS."/" . $table_plural . "/";
  }

  $ext = ".php" ;

  # GENERATE VIEW LIST
  # ====================================================================
  $file_name_list = $folder."list-".$table_plural .".blade" ;

  $file_open = fopen($file_name_list . $ext, "w");

  $str = '';
  $str .= '';
  $str .= generateIndex($table_name, $class_name, $entities, $fields_table, $heads_table , $tipo_inputs ) ;

  fwrite($file_open, $str);
  fclose($file_open);

  echo "View List Generation OK <br> " ;

  # ====================================================================
  /*  GENERATE VIEW NEW */
  # ====================================================================

  $file_name_new = $folder."new-".$table_amigable.".blade" ;

  $file_open = fopen($file_name_new . $ext, "w");

  $str = '';
  $str .= '';
  $str .= generateNewView($table_name, $class_name, $entities, $fields_table, $heads_table , $tipo_inputs,$fields_requireds ) ;

  fwrite($file_open, $str);
  fclose($file_open);

  echo "View New Generation OK <br> " ;

  # ====================================================================
  /*  GENERATE VIEW edit */
  # ====================================================================

  $file_name_edit = $folder."edit-".$table_amigable .".blade" ;

  $file_open = fopen($file_name_edit . $ext, "w");

  $str = '';
  $str .= '';
  $str .= generateEditView($table_name, $class_name, $entities, $fields_table, $heads_table , $tipo_inputs ) ;

  fwrite($file_open, $str);
  fclose($file_open);

  echo "View Edit Generation OK <br> " ;

  echo "============================================= <br> " ;
  echo "View add Modals <br> " ;
  echo "============================================= <br> " ;

  # ====================================================================
    # GENERATE LIST TABLE
  # ====================================================================
  $file_name_list = $folder."list-table-".$table_plural .".blade" ;

  $file_open = fopen($file_name_list . $ext, "w");

  $str = '';
  $str .= '';
  $str .= generateListTable($table_name, $class_name, $entities, $fields_table, $heads_table , $tipo_inputs ) ;

  fwrite($file_open, $str);
  fclose($file_open);

  echo "View List Table Generation OK <br> " ;


  # ====================================================================
  /*  GENERATE VIEW FORM create */
  # ====================================================================

  $file_name_new = $folder."form-create-".$table_amigable.".blade" ;

  $file_open = fopen($file_name_new . $ext, "w");

  $str = '';
  $str .= '';
  $str .= generateFormCreateView($table_name, $class_name, $entities, $fields_table, $heads_table , $tipo_inputs,$fields_requireds ) ;

  fwrite($file_open, $str);
  fclose($file_open);

  echo "View New Generation OK <br> " ;

  # ====================================================================
  /*  GENERATE VIEW FORM edit */
  # ====================================================================

  $file_name_edit = $folder."form-edit-".$table_amigable .".blade" ;

  $file_open = fopen($file_name_edit . $ext, "w");

  $str = '';
  $str .= '';
  $str .= generateFormEditView($table_name, $class_name, $entities, $fields_table, $heads_table , $tipo_inputs ) ;

  fwrite($file_open, $str);
  fclose($file_open);

  echo "View Edit Generation OK <br> " ;

  return "";
  // return "View List Generation OK";

}


