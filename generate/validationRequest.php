<?php

function generateValidationRequest($table_name, $class_name, $entities = array() , $fields_col = array())
{
  $folder = REQUEST;

  $file_name = $folder.$class_name.'Request'  ;
  // echo  $file_name." demos <br>" ;

  $prefix =  generatePrefixTable( $table_name ) ;
  $prefix = !empty($prefix) ? $prefix."_" : "" ;

  $ext = ".php" ;
  $file_open = fopen($file_name . $ext, "w");

  $str = '<?php' . PHP_EOL;
  $str  .= 'namespace App\Request;' . PHP_EOL;
  $str  .= '' . PHP_EOL;

  $str  .= 'use Illuminate\Foundation\Http\FormRequest;' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= 'class '.$class_name.'Request extends FormRequest' . PHP_EOL;
  $str  .= '{' . PHP_EOL;
  $str  .= '  /**' . PHP_EOL;
  $str  .= '   * Determine if the user is authorized to make this request.' . PHP_EOL;
  $str  .= '   *' . PHP_EOL;
  $str  .= '   * @return bool' . PHP_EOL;
  $str  .= '   */' . PHP_EOL;
  $str  .= '  public function authorize()' . PHP_EOL;
  $str  .= '  {' . PHP_EOL;
  $str  .= '    return true;' . PHP_EOL;
  $str  .= '  }' . PHP_EOL;
  $str  .= '  protected $table = "'.$table_name.'";' . PHP_EOL;
  $str  .= '' . PHP_EOL;

  // RULES
  $str  .= '  /**' . PHP_EOL;
  $str  .= '   * Get the validation rules that apply to the request.' . PHP_EOL;
  $str  .= '   *' . PHP_EOL;
  $str  .= '   * @return array' . PHP_EOL;
  $str  .= '   */' . PHP_EOL;
  $str  .= '  public function rules()' . PHP_EOL;
  $str  .= '  {' . PHP_EOL;
  $str  .= '    return [' . PHP_EOL;
  foreach ($entities as $index => $entity)
  {
    if (!fieldNotIncludeInValidationRequest($entity->Field,$prefix ) )
    {
        $str  .= '     \''.$entity->Field .'\'  => [],'. PHP_EOL;
    }
  }
  $str  .= '    ];' . PHP_EOL;
  $str  .= '  }' . PHP_EOL;

  $str  .= '  /**' . PHP_EOL;
  $str  .= '   * Get the validation attributes that apply to the request.' . PHP_EOL;
  $str  .= '   *' . PHP_EOL;
  $str  .= '   * @return array' . PHP_EOL;
  $str  .= '   */' . PHP_EOL;
  $str  .= '  public function attributes()' . PHP_EOL;
  $str  .= '  {' . PHP_EOL;
  $str  .= '    return [' . PHP_EOL;
  foreach ($entities as $index => $entity)
  {
    if (!fieldNotIncludeInValidationRequest($entity->Field,$prefix ) )
    {
        $str  .= '     \''.$entity->Field .'\'  => \''. revemoPrefix($entity->Field, $prefix)  .'\','. PHP_EOL;
    }
  }
  $str  .= '    ];' . PHP_EOL;
  $str  .= '  }' . PHP_EOL;



  $str  .= '' . PHP_EOL;

  $str  .= '}' . PHP_EOL;

  fwrite($file_open, $str);
  fclose($file_open);

  return "Class Validation Request Generated OK";

}



function fieldNotIncludeInValidationRequest($item, $prefix = "")
{

  if(!empty($prefix))
  {
    $item = revemoPrefix($item, $prefix)  ;
  }

  //echo $item ." - $prefix - fieldsNotSaveInController <br>" ;

  $item = strtolower( trim($item) ) ;

  $items = array('id', 'imagen', 'created_at','updated_at','estado','publicar','jerarquia','per_id_padre') ;

  if ( in_array($item, $items) )
  {
    return true ;
  }
  return false ;

}