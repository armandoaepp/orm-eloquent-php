<?php

function generateModel($table_name, $class_name, $entities = array() )
{
  $folder = MODELS;

  $file_name = $folder.$class_name ;

  $ext = ".php" ;
  $file_open = fopen($file_name . $ext, "w");

  $str = '<?php
  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  class '.$class_name.' extends Model {

    protected $table = "'.$table_name.'";

    protected $primaryKey = "'.$entities[0]->Field.'";

    protected $guarded = ["'.$entities[0]->Field.'"];

    // public $timestamps = false;

    // protected $hidden = ["created_at", "updated_at"];


  }
  ';

  fwrite($file_open, $str);
  fclose($file_open);

  return "Class Model Generated OK";

}