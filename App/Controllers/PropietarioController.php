<?php
  namespace App\Controllers;

  /**
   * [Class Controller]
   * Autor: Armando E. Pisfil Puemape
   * twitter: @armandoaepp
   * email: armandoaepp@gmail.com
  */

  use App\Models\Propietario;

  class PropietarioController {

    public function __construct() {}

    public function getAll()
    {
      try
      {

        $data = Propietario::get();

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

      $propietario = Propietario::where(["nombre" => $nombre])->first();

      if (empty($propietario))
      {
        $propietario = new Propietario();
        $propietario->id = $id;
        $propietario->nombre = $nombre;
        $propietario->apellidos = $apellidos;
        $propietario->email = $email;
        $propietario->celular = $celular;
        $propietario->glosa = $glosa;
        $propietario->estado = $estado;
        $propietario->created_at = $created_at;
        $propietario->updated_at = $updated_at;
        
        $status = $propietario->save();
        
        $id = $propietario->id;
        
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

      if (empty($id))
      {
        $propietario = Propietario::find($id);
        $propietario->id = $id;
        $propietario->nombre = $nombre;
        $propietario->apellidos = $apellidos;
        $propietario->email = $email;
        $propietario->celular = $celular;
        $propietario->glosa = $glosa;
        $propietario->created_at = $created_at;
        $propietario->updated_at = $updated_at;
        
        $status = $propietario->save();
        
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

  public function find( $id )
  {
    try
    {

      $data = Propietario::find($id);

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
      $propietario = Propietario::find( id ) ;

      if (empty($propietario))
      {
        $propietario = new Propietario();
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $propietario->estado = 1;
          $propietario->save();
            
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $propietario->forceDelete();
        
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

      if (empty($id))
      {
        $propietario = Propietario::find($id);
        $propietario->estado = $estado;
        
        $status = $propietario->save();
        
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

      $data = Propietario::where("estado", $estado)->get();

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}