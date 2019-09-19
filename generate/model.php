<?php

function generateModel($table_name, $class_name, $entities = array() , $fields_col = array())
{
  $folder = MODELS;

  $file_name = $folder.$class_name ;

  $ext = ".php" ;
  $file_open = fopen($file_name . $ext, "w");

  $str = '<?php' . PHP_EOL;
  $str  .= 'namespace App\Models;' . PHP_EOL;
  $str  .= '' . PHP_EOL;

  $str  .= 'use Illuminate\Database\Eloquent\Model;' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= 'class '.$class_name.' extends Model' . PHP_EOL;
  $str  .= '{' . PHP_EOL;
  $str  .= '  protected $table = "'.$table_name.'";' . PHP_EOL;
  $str  .= '' . PHP_EOL;




  $str  .= '  protected $fillable = [' . PHP_EOL;
  foreach ($entities as $index => $entity)
  {
    if ( $index > 0 )
    {
      if($entity->Field != "created_at" & $entity->Field != "updated_at")
      {
        $str  .= '     \''.$entity->Field .'\','. PHP_EOL;
      }
    }

  }
  $str  .= '  ];' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '  protected $primaryKey = "'.$entities[0]->Field.'";' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '  protected $guarded = ["'.$entities[0]->Field.'"];' . PHP_EOL;
  $str  .= '' . PHP_EOL;

  if (in_array('created_at', $fields_col) || in_array('updated_at', $fields_col) )
  {
    $str  .= '  public $timestamps = true;' . PHP_EOL;
    $str  .= '' . PHP_EOL;

    if (in_array('per_id_padre', $fields_col))
    {
      $str  .= '  protected $hidden = ["per_id_padre","created_at", "updated_at"];' . PHP_EOL;
    }
    else
    {
      $str  .= '  protected $hidden = ["created_at", "updated_at"];' . PHP_EOL;
    }

  }
  else {
    $str  .= '  public $timestamps = false;' . PHP_EOL;

    if (in_array('per_id_padre', $fields_col))
    {
      $str  .= '' . PHP_EOL;
      $str  .= '  protected $hidden = ["per_id_padre"];' . PHP_EOL;
    }
  }

  $str  .= '' . PHP_EOL;

  $str  .= '}' . PHP_EOL;

  fwrite($file_open, $str);
  fclose($file_open);

  return "Class Model Generated OK";

}