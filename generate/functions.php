<?php

# Method save for controllers
function save()
{
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
  $str  .= '      $'.$table_name.' = '.$class_name.'::where(["'.$entities[1]->Field.'" => $'.$entities[1]->Field.'])->first();' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      if (empty($'.$table_name.'))' . PHP_EOL;
  $str  .= '      {' . PHP_EOL;
  $str  .= '        $'.$table_name.' = new '.$class_name.'();' . PHP_EOL;

  foreach ($entities as $index => $entity)
  {
    if (!fieldsNotSaveInController($entity->Field) )
    {
      $str  .= '        $'.$table_name.'->'.$entity->Field .' = $'.$entity->Field .';'. PHP_EOL;
    }
  }

  $str  .= '        ' . PHP_EOL;
  $str  .= '        $status = $'.$table_name.'->save();' . PHP_EOL;
  $str  .= '        ' . PHP_EOL;
  $str  .= '        $id = $'.$table_name.'->'.$entities[0]->Field.';' . PHP_EOL;
  $str  .= '        ' . PHP_EOL;
  $str  .= '        $message = "Operancion Correcta";' . PHP_EOL;
  $str  .= '        ' . PHP_EOL;
  $str  .= '      }' . PHP_EOL;
  $str  .= '      else' . PHP_EOL;
  $str  .= '      {' . PHP_EOL;
  $str  .= '        $message = "¡El registro ya existe!";' . PHP_EOL;
  $str  .= '      }' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      $data = ["message" => $message, "status" => $status, "data" => ["id" => $id],];' . PHP_EOL;
  $str  .= '    ' . PHP_EOL;
  $str  .= '      return $data;' . PHP_EOL;
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

# Method update for controllers
function update()
{
  global $table_name ;
  global $class_name ;
  global $entities ;

  $str  = '' . PHP_EOL;
  $str  .= '  public function update( $params = array() )' . PHP_EOL;
  $str  .= '  {' . PHP_EOL;
  $str  .= '    try' . PHP_EOL;
  $str  .= '    {' . PHP_EOL;
  $str  .= '      extract($params) ;' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      $status  = false;' . PHP_EOL;
  $str  .= '      $message = "";' . PHP_EOL;
  // $str  .= '' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      if (empty($'.$entities[0]->Field.'))' . PHP_EOL;
  $str  .= '      {' . PHP_EOL;
  $str  .= '        $'.$table_name.' = '.$class_name.'::find($'.$entities[0]->Field.');' . PHP_EOL;

  foreach ($entities as $index => $entity)
  {
    if (!fieldsNotUpdateInController($entity->Field) )
    {
      $str  .= '        $'.$table_name.'->'.$entity->Field .' = $'.$entity->Field .';'. PHP_EOL;
    }
  }

  $str  .= '        ' . PHP_EOL;
  $str  .= '        $status = $'.$table_name.'->save();' . PHP_EOL;
  $str  .= '        ' . PHP_EOL;
  $str  .= '        $message = "Operancion Correcta";' . PHP_EOL;
  $str  .= '        ' . PHP_EOL;
  $str  .= '      }' . PHP_EOL;
  $str  .= '      else' . PHP_EOL;
  $str  .= '      {' . PHP_EOL;
  $str  .= '        $message = "¡El registro ya existe!";' . PHP_EOL;
  $str  .= '      }' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      $data = ["message" => $message, "status" => $status, "data" =>[],];' . PHP_EOL;
  $str  .= '    ' . PHP_EOL;
  $str  .= '      return $data;' . PHP_EOL;
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

# Method find for controllers
function find()
{
  global $table_name ;
  global $class_name ;
  global $entities ;

  $str  = '' . PHP_EOL;
  $str  .= '  public function find( $'.$entities[0]->Field.' )' . PHP_EOL;
  $str  .= '  {' . PHP_EOL;
  $str  .= '    try' . PHP_EOL;
  $str  .= '    {' . PHP_EOL;
  // $str  .= '' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      $data = '.$class_name.'::find($'.$entities[0]->Field.');' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      return $data;' . PHP_EOL;
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

# Method updateEstado for controllers
function updateEstado()
{
  global $table_name ;
  global $class_name ;
  global $entities ;

  $str  = '' . PHP_EOL;
  $str  .= '  public function updateEstado( $params = array() )' . PHP_EOL;
  $str  .= '  {' . PHP_EOL;
  $str  .= '    try' . PHP_EOL;
  $str  .= '    {' . PHP_EOL;
  $str  .= '      extract($params) ;' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      $status  = false;' . PHP_EOL;
  $str  .= '      $message = "";' . PHP_EOL;
  // $str  .= '' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      if (empty($'.$entities[0]->Field.'))' . PHP_EOL;
  $str  .= '      {' . PHP_EOL;
  $str  .= '        $'.$table_name.' = '.$class_name.'::find($'.$entities[0]->Field.');' . PHP_EOL;
  $str  .= '        $'.$table_name.'->estado = $estado;'. PHP_EOL;

  $str  .= '        ' . PHP_EOL;
  $str  .= '        $status = $'.$table_name.'->save();' . PHP_EOL;
  $str  .= '        ' . PHP_EOL;
  $str  .= '        $message = "Operancion Correcta";' . PHP_EOL;
  $str  .= '        ' . PHP_EOL;
  $str  .= '      }' . PHP_EOL;
  $str  .= '      else' . PHP_EOL;
  $str  .= '      {' . PHP_EOL;
  $str  .= '        $message = "¡El identificador es incorrecto!";' . PHP_EOL;
  $str  .= '      }' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      $data = ["message" => $message, "status" => $status, "data" =>[],];' . PHP_EOL;
  $str  .= '    ' . PHP_EOL;
  $str  .= '      return $data;' . PHP_EOL;
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

# Method delete for controllers
function delete()
{
  global $table_name ;
  global $class_name ;
  global $entities ;

  $str  = '' . PHP_EOL;
  $str  .= '  public function delete( $params = array() )' . PHP_EOL;
  $str  .= '  {' . PHP_EOL;
  $str  .= '    extract($params) ;' . PHP_EOL;
  $str  .= '    try' . PHP_EOL;
  $str  .= '    {' . PHP_EOL;
  $str  .= '      $status  = false;' . PHP_EOL;
  $str  .= '      $message = "";' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      $historial = !empty($historial) ? $historial: "si";' . PHP_EOL;
  $str  .= '      $'.$table_name.' = '.$class_name.'::find( '.$entities[0]->Field.' ) ;' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      if (empty($'.$table_name.'))' . PHP_EOL;
  $str  .= '      {' . PHP_EOL;
  $str  .= '        $'.$table_name.' = new '.$class_name.'();' . PHP_EOL;

  $str  .= '        #conservar en base de datos' . PHP_EOL;
  $str  .= '        if ( $historial == "si" )' . PHP_EOL;
  $str  .= '        {' . PHP_EOL;
  $str  .= '          $'.$table_name.'->estado = 1;' . PHP_EOL;
  $str  .= '          $'.$table_name.'->save();' . PHP_EOL;
  $str  .= '            ' . PHP_EOL;
  $str  .= '          $status = true;' . PHP_EOL;
  $str  .= '          $message = "Registro Eliminado";' . PHP_EOL;
  $str  .= '            ' . PHP_EOL;
  $str  .= '        }elseif( $historial == "no"  ) {' . PHP_EOL;
  $str  .= '          $'.$table_name.'->forceDelete();' . PHP_EOL;
  $str  .= '          $status = true;' . PHP_EOL;
  $str  .= '          $message = "Registro eliminado de la base de datos";' . PHP_EOL;
  $str  .= '        }' . PHP_EOL;

  $str  .= '        $status = $'.$table_name.'->save();' . PHP_EOL;
  $str  .= '        ' . PHP_EOL;
  $str  .= '        $id = $'.$table_name.'->'.$entities[0]->Field.';' . PHP_EOL;
  $str  .= '        ' . PHP_EOL;
  $str  .= '        $message = "Operancion Correcta";' . PHP_EOL;
  $str  .= '        ' . PHP_EOL;
  $str  .= '      }' . PHP_EOL;
  $str  .= '      else' . PHP_EOL;
  $str  .= '      {' . PHP_EOL;
  $str  .= '        $message = "¡El registro ya existe!";' . PHP_EOL;
  $str  .= '      }' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      $data = ["message" => $message, "status" => $status, "data" => ["id" => $id],];' . PHP_EOL;
  $str  .= '    ' . PHP_EOL;
  $str  .= '      return $data;' . PHP_EOL;
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
