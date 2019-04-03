<?php
function save(){
  global $table_name ;
  global $class_name ;
  global $entities ;

  $str  = '' . PHP_EOL;
  $str  .= '  public function save( $params = array() )' . PHP_EOL;
  $str  .= '  {' . PHP_EOL;
  $str  .= '    extract($params) ;' . PHP_EOL;
  $str  .= '    try' . PHP_EOL;
  $str  .= '    {' . PHP_EOL;
  $str  .= '      $id      = null;' . PHP_EOL;
  $str  .= '      $status  = false;' . PHP_EOL;
  $str  .= '      $message = "";' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      $'.$table_name.' = '.$class_name.'::where(["nombre" => $nombre])->first();' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      if (empty($'.$table_name.'))' . PHP_EOL;
  $str  .= '      {' . PHP_EOL;
  $str  .= '        $'.$table_name.' = new '.$class_name.'();' . PHP_EOL;

  foreach ($entities as $index => $entity)
  {
    $str  .= '        $'.$table_name.'->'.$entity->Field .' = $'.$entity->Field .';'. PHP_EOL;
  }

  $str  .= '        ' . PHP_EOL;
  $str  .= '        ' . PHP_EOL;
  $str  .= '        $status = $'.$table_name.'->save();' . PHP_EOL;
  $str  .= '        ' . PHP_EOL;
  $str  .= '        $id = $'.$table_name.'->id ;' . PHP_EOL;
  $str  .= '        ' . PHP_EOL;
  $str  .= '        $message = "Operancion Correcta";' . PHP_EOL;
  $str  .= '        ' . PHP_EOL;
  $str  .= '      }' . PHP_EOL;
  $str  .= '      else' . PHP_EOL;
  $str  .= '      {' . PHP_EOL;
  $str  .= '        $message = "¡El Registro ya existe!";' . PHP_EOL;
  $str  .= '      }' . PHP_EOL;

  $str  .= '      $data = ["message" => $message, "status" => $status, "data" => $id,];' . PHP_EOL;
  $str  .= '    ' . PHP_EOL;
  $str  .= '      return $data;' . PHP_EOL;
  $str  .= '    ' . PHP_EOL;
  $str  .= '    ' . PHP_EOL;
  $str  .= '    }' . PHP_EOL;
  $str  .= '    catch (Exception $e)' . PHP_EOL;
  $str  .= '    {' . PHP_EOL;
  $str  .= '      throw new Exception($e->getMessage());' . PHP_EOL;
  $str  .= '    }' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '  }' . PHP_EOL;
  $str  .= '' . PHP_EOL;

  return $str ;
}
