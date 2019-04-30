<?php

# Method find for controllers
function getAll($table_name, $class_name, $entities = array())
{
  $table_amigable = App\Helpers\UrlHelper::urlFriendly($table_name);
  $table_plural = str_plural($table_amigable) ;
  // echo $table_amigable. "<br>" ;

  $str  = '' . PHP_EOL;
  $str  .= '  public function getAll()' . PHP_EOL;
  $str  .= '  {' . PHP_EOL;
  $str  .= '    try' . PHP_EOL;
  $str  .= '    {' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      $data = '.$class_name.'::get();' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      return view(\'admin.'.$table_plural.'.list-'.$table_plural.'\')->with(compact(\'data\'));' . PHP_EOL;
  // $str  .= '      return $data;' . PHP_EOL;
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

function newRegister($table_name, $class_name, $entities = array())
{
  $table_amigable = App\Helpers\UrlHelper::urlFriendly($table_name);
  $table_plural = str_plural($table_amigable) ;

  $str  = '' . PHP_EOL;
  $str  .= '  public function newRegister( Request $request )' . PHP_EOL;
  $str  .= '  {' . PHP_EOL;
  $str  .= '    try' . PHP_EOL;
  $str  .= '    {' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      return view(\'admin.'.$table_plural.'.new-'.$table_amigable.'\');' . PHP_EOL;
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

# Method save for controllers
function save($table_name, $class_name, $entities = array())
{
  $table_amigable = App\Helpers\UrlHelper::urlFriendly($table_name);
  $table_plural = str_plural($table_amigable) ;

  $str  = '' . PHP_EOL;
  $str  .= '  public function save( Request $request )' . PHP_EOL;
  $str  .= '  {' . PHP_EOL;
  $str  .= '    try' . PHP_EOL;
  $str  .= '    {' . PHP_EOL;
  // $str  .= '      $id      = null;' . PHP_EOL;
  $str  .= '      $status  = false;' . PHP_EOL;
  $str  .= '      $message = "";' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  foreach ($entities as $index => $entity)
  {
    if (!fieldsNotSaveInController($entity->Field) )
    {
      $str  .= '      $'.$entity->Field .' = $request->input(\''.$entity->Field .'\');'. PHP_EOL;
    }
  }
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
  $str  .= '      $data = ["message" => $message, "status" => $status, "data" => [$'.$table_name.'],];' . PHP_EOL;
  $str  .= '    ' . PHP_EOL;
  $str  .= '      return redirect()->route(\'admin-'.$table_plural.'\');' . PHP_EOL;
  // $str  .= '      return $data;' . PHP_EOL;
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
# Method edit for controllers
function edit($table_name, $class_name, $entities = array())
{
  $table_amigable = App\Helpers\UrlHelper::urlFriendly($table_name);
  $table_plural = str_plural($table_amigable) ;

  $str  = '' . PHP_EOL;
  $str  .= '  public function edit( $'.$entities[0]->Field.' )' . PHP_EOL;
  $str  .= '  {' . PHP_EOL;
  $str  .= '    try' . PHP_EOL;
  $str  .= '    {' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      $data = '.$class_name.'::find($id);' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      return view(\'admin.'.$table_plural.'.edit-'.$table_amigable.'\')->with(compact(\'data\'));' . PHP_EOL;
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
  $table_amigable = App\Helpers\UrlHelper::urlFriendly($table_name);
  $table_plural = str_plural($table_amigable) ;

  $str  = '' . PHP_EOL;
  $str  .= '  public function update( Request $request )' . PHP_EOL;
  $str  .= '  {' . PHP_EOL;
  $str  .= '    try' . PHP_EOL;
  $str  .= '    {' . PHP_EOL;
  // $str  .= '      extract($params) ;' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      $status  = false;' . PHP_EOL;
  $str  .= '      $message = "";' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  foreach ($entities as $index => $entity)
  {
    if (!fieldsNotUpdateInController($entity->Field) )
    {
      $str  .= '      $'.$entity->Field .' = $request->input(\''.$entity->Field .'\');'. PHP_EOL;
    }
  }
  $str  .= '' . PHP_EOL;
  $str  .= '      if (!empty($'.$entities[0]->Field.'))' . PHP_EOL;
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
  $str  .= '      return redirect()->route(\'admin-'.$table_plural.'\');;' . PHP_EOL;
  // $str  .= '      return $data;' . PHP_EOL;
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
  $table_amigable = App\Helpers\UrlHelper::urlFriendly($table_name);
  $table_plural = str_plural($table_amigable) ;

  $str  = '' . PHP_EOL;
  $str  .= '  public function delete( Request $request )' . PHP_EOL;
  $str  .= '  {' . PHP_EOL;
  // $str  .= '    extract($params) ;' . PHP_EOL;
  $str  .= '    try' . PHP_EOL;
  $str  .= '    {' . PHP_EOL;
  $str  .= '      $status  = false;' . PHP_EOL;
  $str  .= '      $message = "";' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      $id = $request->input(\'id\');' . PHP_EOL;
  $str  .= '      $estado = $request->input(\'estado\');' . PHP_EOL;
  $str  .= '      $historial = !empty($request->input(\'historial\')) ? $request->input(\'historial\') : "si";' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      if ($estado == 1) {' . PHP_EOL;
  $str  .= '        $estado = 0;' . PHP_EOL;
  $str  .= '      } else {' . PHP_EOL;
  $str  .= '        $estado = 1;' . PHP_EOL;
  $str  .= '      }' . PHP_EOL;
  $str  .= '' . PHP_EOL;

  $str  .= '      $'.$table_name.' = '.$class_name.'::find( $'.$entities[0]->Field.' ) ;' . PHP_EOL;
  $str  .= '' . PHP_EOL;
  $str  .= '      if (!empty($'.$table_name.'))' . PHP_EOL;
  $str  .= '      {' . PHP_EOL;
  // $str  .= '        $'.$table_name.' = new '.$class_name.'();' . PHP_EOL;

  $str  .= '        #conservar en base de datos' . PHP_EOL;
  $str  .= '        if ( $historial == "si" )' . PHP_EOL;
  $str  .= '        {' . PHP_EOL;
  $str  .= '          $'.$table_name.'->estado = $estado;' . PHP_EOL;
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
  $str  .= '         $data = $plan;' . PHP_EOL;
  $str  .= '        ' . PHP_EOL;
  $str  .= '      }' . PHP_EOL;
  $str  .= '      else' . PHP_EOL;
  $str  .= '      {' . PHP_EOL;
  $str  .= '        $message = "¡El registro no exite o el identificador es incorrecto!";' . PHP_EOL;
  $str  .= '        $data = $request->all();' . PHP_EOL;
  $str  .= '      }' . PHP_EOL;
  // $str  .= '' . PHP_EOL;
  // $str  .= '      $data = ["message" => $message, "status" => $status, "errors"  => [], "data" => $data],];' . PHP_EOL;
  $str  .= '    ' . PHP_EOL;
  $str  .= '      return \Response::json([' . PHP_EOL;
  $str  .= '                "message" => $message,' . PHP_EOL;
  $str  .= '                "status"  => $status,' . PHP_EOL;
  $str  .= '                "errors"  => [],' . PHP_EOL;
  $str  .= '                "data"    => [$data],' . PHP_EOL;
  $str  .= '              ]);' . PHP_EOL;
  // $str  .= '      return $data;' . PHP_EOL;
  $str  .= '    ' . PHP_EOL;
  $str  .= '    }' . PHP_EOL;
  $str  .= '    catch (\Throwable $e) ' . PHP_EOL;
  $str  .= '    {' . PHP_EOL;
  $str  .= '      return \Response::json([' . PHP_EOL;
  $str  .= '                "message" => "Operación fallida en el servidor",' . PHP_EOL;
  $str  .= '                "status"  => $status,' . PHP_EOL;
  $str  .= '                "errors"  => [$e->getMessage(), ],' . PHP_EOL;
  $str  .= '                "data"    => [],' . PHP_EOL;
  $str  .= '              ]);' . PHP_EOL;
  // $str  .= '      throw new Exception($e->getMessage());' . PHP_EOL;
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