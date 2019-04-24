<?php
  namespace App\Controllers;

  /**
   * [Class Controller]
   * Autor: Armando E. Pisfil Puemape
   * twitter: @armandoaepp
   * email: armandoaepp@gmail.com
  */

  use App\Models\User;

  class UserController {

    public function __construct() {}

    public function getAll()
    {
      try
      {

        $data = User::get();

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

      $user = User::where(["nombre" => $nombre])->first();

      if (empty($user))
      {
        $user = new User();
        $user->user_id = $user_id;
        $user->nombre = $nombre;
        $user->apellidos = $apellidos;
        $user->email = $email;
        $user->password = $password;
        $user->estado = $estado;
        
        $status = $user->save();
        
        $id = $user->user_id;
        
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
        $user = User::find($user_id);
        $user->user_id = $user_id;
        $user->nombre = $nombre;
        $user->apellidos = $apellidos;
        $user->email = $email;
        $user->password = $password;
        
        $status = $user->save();
        
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

      $data = User::find($user_id);

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
      $user = User::find( user_id ) ;

      if (empty($user))
      {
        $user = new User();
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $user->estado = 1;
          $user->save();
            
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $user->forceDelete();
        
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
        $user = User::find($user_id);
        $user->estado = $estado;
        
        $status = $user->save();
        
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

      $data = User::where("estado", $estado)->get();

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}