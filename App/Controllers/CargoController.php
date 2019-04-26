<?php
  namespace App\Controllers;

  /**
   * [Class Controller]
   * Autor: Armando E. Pisfil Puemape
   * twitter: @armandoaepp
   * email: armandoaepp@gmail.com
  */

  use App\Models\Cargo;

  class CargoController {

    public function __construct() {}

    public function getAll()
    {
      try
      {

        $data = Cargo::get();

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

      $cargo = Cargo::where(["code" => $code])->first();

      if (empty($cargo))
      {
        $cargo = new Cargo();
        $cargo->id = $id;
        $cargo->code = $code;
        $cargo->nombre = $nombre;
        $cargo->apellidos = $apellidos;
        $cargo->amount = $amount;
        $cargo->currency_code = $currency_code;
        $cargo->description = $description;
        $cargo->email = $email;
        $cargo->source_id = $source_id;
        $cargo->estado = $estado;
        
        $status = $cargo->save();
        
        $id = $cargo->id;
        
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
        $cargo = Cargo::find($id);
        $cargo->id = $id;
        $cargo->code = $code;
        $cargo->nombre = $nombre;
        $cargo->apellidos = $apellidos;
        $cargo->amount = $amount;
        $cargo->currency_code = $currency_code;
        $cargo->description = $description;
        $cargo->email = $email;
        $cargo->source_id = $source_id;
        
        $status = $cargo->save();
        
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

      $data = Cargo::find($id);

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
      $cargo = Cargo::find( id ) ;

      if (empty($cargo))
      {
        $cargo = new Cargo();
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $cargo->estado = 1;
          $cargo->save();
            
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $cargo->forceDelete();
        
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
        $cargo = Cargo::find($id);
        $cargo->estado = $estado;
        
        $status = $cargo->save();
        
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

      $data = Cargo::where("estado", $estado)->get();

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}