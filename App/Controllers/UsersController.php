<?php
  namespace App\Controllers;

  /**
   * [Class Controller]
   * Autor: Armando E. Pisfil Puemape
   * twitter: @armandoaepp
   * email: armandoaepp@gmail.com
  */

  use App\Models\Users;

  class UsersController {

    public function __construct() {}

    public function getAll()
    {
      try
      {

        $data = Users::get();

        return $data ;
      }
      catch (Exception $e)
      {
        throw new Exception($e->getMessage());
      }
    }
    
  public function save( $params = array() )
  {
    extract($params) ;
    try
    {
      $id      = null;
      $status  = false;
      $message = "";

      $users = Users::where(["nombres" => $nombres])->first();

      if (empty($users))
      {
        $users = new Users();
        $users->user_id = $user_id;
        $users->nombres = $nombres;
        $users->apellidos = $apellidos;
        $users->email = $email;
        $users->password = $password;
        $users->max_sesions = $max_sesions;
        $users->estado = $estado;
        
        $status = $users->save();
        
        $id = $users->user_id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => ["id" => $id],];
    
      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function update( $params = array() )
  {
    try
    {
      extract($params) ;

      $status  = false;
      $message = "";

      if (empty($user_id))
      {
        $users = Users::find($user_id);
        $users->user_id = $user_id;
        $users->nombres = $nombres;
        $users->apellidos = $apellidos;
        $users->email = $email;
        $users->password = $password;
        $users->max_sesions = $max_sesions;
        
        $status = $users->save();
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function find( $user_id )
  {
    try
    {

      $data = Users::find($user_id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function delete( $params = array() )
  {
    extract($params) ;
    try
    {
      $status  = false;
      $message = "";

      $historial = !empty($historial) ? $historial: "si";
      $users = Users::find( user_id ) ;

      if (empty($users))
      {
        $users = new Users();
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $users->estado = 1;
          $users->save();
            
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $users->forceDelete();
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
      }
      else
      {
        $message = "¡El registro no exite o el identificador es incorrecto!";
      }

      $data = ["message" => $message, "status" => $status, "data" => ["id" => $id],];
    
      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function updateStatus( $params = array() )
  {
    try
    {
      extract($params) ;

      $status  = false;
      $message = "";

      if (empty($user_id))
      {
        $users = Users::find($user_id);
        $users->estado = $estado;
        
        $status = $users->save();
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El identificador es incorrecto!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function getByStatus( $params = array()  )
  {
    try
    {
      extract($params) ;

      $data = Users::where("estado", $estado)->get();

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}