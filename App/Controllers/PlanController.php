<?php
  namespace App\Controllers;

  /**
   * [Class Controller]
   * Autor: Armando E. Pisfil Puemape
   * twitter: @armandoaepp
   * email: armandoaepp@gmail.com
  */

  use App\Models\Plan;

  class PlanController {

    public function __construct() {}

    public function getAll()
    {
      try
      {

        $data = Plan::get();

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

      $plan = Plan::where(["nombre" => $nombre])->first();

      if (empty($plan))
      {
        $plan = new Plan();
        $plan->id = $id;
        $plan->nombre = $nombre;
        $plan->espacio = $espacio;
        $plan->num_databases = $num_databases;
        $plan->num_mails = $num_mails;
        $plan->estado = $estado;
        $plan->created_at = $created_at;
        $plan->updated_at = $updated_at;
        
        $status = $plan->save();
        
        $id = $plan->id;
        
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
        $plan = Plan::find($id);
        $plan->id = $id;
        $plan->nombre = $nombre;
        $plan->espacio = $espacio;
        $plan->num_databases = $num_databases;
        $plan->num_mails = $num_mails;
        $plan->created_at = $created_at;
        $plan->updated_at = $updated_at;
        
        $status = $plan->save();
        
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

      $data = Plan::find($id);

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
      $plan = Plan::find( id ) ;

      if (empty($plan))
      {
        $plan = new Plan();
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $plan->estado = 1;
          $plan->save();
            
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $plan->forceDelete();
        
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
        $plan = Plan::find($id);
        $plan->estado = $estado;
        
        $status = $plan->save();
        
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

      $data = Plan::where("estado", $estado)->get();

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}