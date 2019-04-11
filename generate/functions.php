<?php

# Method save for controllers
function save($table_name, $class_name, $entities = array())
{

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
  // $str  .= '' . PHP_EOL;

  return $str ;
}

# Method update for controllers
function update($table_name, $class_name, $entities = array())
{

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
  // $str  .= '' . PHP_EOL;

  return $str ;
}

# Method find for controllers
function find($table_name, $class_name, $entities = array())
{

  $str  = '' . PHP_EOL;
  $str  .= '  public function find( $'.$entities[0]->Field.' )' . PHP_EOL;
  $str  .= '  {' . PHP_EOL;
  $str  .= '    try' . PHP_EOL;
  $str  .= '    {' . PHP_EOL;
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
  // $str  .= '' . PHP_EOL;

  return $str ;
}

# Method delete for controllers
function delete($table_name, $class_name, $entities = array())
{

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
  $str  .= '        ' . PHP_EOL;
  $str  .= '          $status = true;' . PHP_EOL;
  $str  .= '          $message = "Registro eliminado de la base de datos";' . PHP_EOL;
  $str  .= '        }' . PHP_EOL;
  $str  .= '        ' . PHP_EOL;
  $str  .= '      }' . PHP_EOL;
  $str  .= '      else' . PHP_EOL;
  $str  .= '      {' . PHP_EOL;
  $str  .= '        $message = "¡El registro no exite o el identificador es incorrecto!";' . PHP_EOL;
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
  // $str  .= '' . PHP_EOL;

  return $str ;
}

# Method updateStatus for controllers
function updateStatus($table_name, $class_name, $entities = array())
{

  $str  = '' . PHP_EOL;
  $str  .= '  public function updateStatus( $params = array() )' . PHP_EOL;
  $str  .= '  {' . PHP_EOL;
  $str  .= '    try' . PHP_EOL;
  $str  .= '    {' . PHP_EOL;
  $str  .= '      extract($params) ;' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      $status  = false;' . PHP_EOL;
  $str  .= '      $message = "";' . PHP_EOL;
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
  // $str  .= '' . PHP_EOL;

  return $str ;
}

# Method getByStatus for controllers
function getByStatus($table_name, $class_name, $entities = array())
{

  $str  = '' . PHP_EOL;
  $str  .= '  public function getByStatus( $params = array()  )' . PHP_EOL;
  $str  .= '  {' . PHP_EOL;
  $str  .= '    try' . PHP_EOL;
  $str  .= '    {' . PHP_EOL;
  $str  .= '      extract($params) ;' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      $data = '.$class_name.'::where("estado", $estado)->get();' . PHP_EOL;
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
  // $str  .= '' . PHP_EOL;

  return $str ;
}

# Method updatePublish for controllers
function updatePublish($table_name, $class_name, $entities = array())
{

  $str  = '' . PHP_EOL;
  $str  .= '  public function updatePublish( $params = array() )' . PHP_EOL;
  $str  .= '  {' . PHP_EOL;
  $str  .= '    try' . PHP_EOL;
  $str  .= '    {' . PHP_EOL;
  $str  .= '      extract($params) ;' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      $status  = false;' . PHP_EOL;
  $str  .= '      $message = "";' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      if (empty($'.$entities[0]->Field.'))' . PHP_EOL;
  $str  .= '      {' . PHP_EOL;
  $str  .= '        $'.$table_name.' = '.$class_name.'::find($'.$entities[0]->Field.');' . PHP_EOL;
  $str  .= '        if ($'.$table_name.')' . PHP_EOL;
  $str  .= '        {' . PHP_EOL;
  $str  .= '          $'.$table_name.'->publish = $publish;' . PHP_EOL;
  $str  .= '          $'.$table_name.'->save();' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '          $status = true;' . PHP_EOL;
  $str  .= '          $message = "Operación Correcta" ;' . PHP_EOL;
  $str  .= '        }else{' . PHP_EOL;
  $str  .= '          $message = "¡El identificador no exite!" ; ;' . PHP_EOL;
  $str  .= '        }' . PHP_EOL;

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
  // $str  .= '' . PHP_EOL;

  return $str ;
}

# Method getPublished for controllers
function getPublished($table_name, $class_name, $entities = array())
{

  $str  = '' . PHP_EOL;
  $str  .= '  public function getPublished(  $params = array()  )' . PHP_EOL;
  $str  .= '  {' . PHP_EOL;
  $str  .= '    try' . PHP_EOL;
  $str  .= '    {' . PHP_EOL;
    $str  .= '      extract($params) ;' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      $data = '.$class_name.'::where("publish", $publish)->get();' . PHP_EOL;
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
  // $str  .= '' . PHP_EOL;

  return $str ;
}