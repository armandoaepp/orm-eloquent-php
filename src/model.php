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
      // if($entity->Field != "created_at" & $entity->Field != "updated_at")
      if (!fieldsNotFillableModel($entity->Field) && $index > 0) 
      {
        $str  .= '     \''.$entity->Field .'\','. PHP_EOL;
      }
    }

  }
  $str  .= '  ];' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '  protected $primaryKey = \''.$entities[0]->Field.'\';' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '  protected $guarded = [\''.$entities[0]->Field.'\'];' . PHP_EOL;
  $str  .= '' . PHP_EOL;


  
  if (in_array('created_at', $fields_col) || in_array('updated_at', $fields_col) )
  {
    $str  .= '  public $timestamps = true;' . PHP_EOL;
    $str  .= '' . PHP_EOL;

    /* if (in_array('sede_id', $fields_col))
    {
      $str  .= '  protected $hidden = ["sede_id","created_at", "updated_at"];' . PHP_EOL;
    }
    else
    {
      $str  .= '  protected $hidden = ["created_at", "updated_at"];' . PHP_EOL;
    } */

  }
  else {
    $str  .= '  public $timestamps = false;' . PHP_EOL;
/* 
    if (in_array('sede_id', $fields_col))
    {
      $str  .= '' . PHP_EOL;
      $str  .= '  protected $hidden = ["sede_id"];' . PHP_EOL;
    } */
  }
  
  $hiddens = [] ;

  if( in_array('created_at', $fields_col)){
    $hiddens[] = '\'created_at\'' ;
  } 

  if( in_array('updated_at', $fields_col)){ 
    $hiddens[] = '\'updated_at\'' ;
  } 
  
  if( in_array('sede_id', $fields_col)){ 
    $hiddens[] = '\'sede_id\'' ;
  } 

  if( in_array('user_id_reg', $fields_col)){
    $hiddens[] = '\'user_id_reg\'' ; 
  } 

  if( in_array('user_id_upd', $fields_col)){
    $hiddens[] = '\'user_id_upd\'' ; 
  }

  if(count($hiddens) > 0 ){
    $item_hiddens =  implode(",",$hiddens);
    $str  .= '  protected $hidden = ['.$item_hiddens.'];' . PHP_EOL;
    
  }
 

  $str  .= '' . PHP_EOL;

  $str  .= '}' . PHP_EOL;

  fwrite($file_open, $str);
  fclose($file_open);

  return "Class Model Generated OK";

}