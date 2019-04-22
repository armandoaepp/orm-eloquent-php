<?php
  namespace App\Controllers;

  /**
   * [Class Controller]
   * Autor: Armando E. Pisfil Puemape
   * twitter: @armandoaepp
   * email: armandoaepp@gmail.com
  */

  use App\Models\CuentaHost;

class CuentaHostController {

  public function __construct() {}

  public function getAll()
  {
    try
    {

      $data = CuentaHost::get();

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

      $cuenta_host = CuentaHost::where(["propietario_id" => $propietario_id])->first();

      if (empty($cuenta_host))
      {
        $cuenta_host = new CuentaHost();
        $cuenta_host->id = $id;
        $cuenta_host->propietario_id = $propietario_id;
        $cuenta_host->plan_id = $plan_id;
        $cuenta_host->dominio = $dominio;
        $cuenta_host->descripcion = $descripcion;
        $cuenta_host->solo_host = $solo_host;
        $cuenta_host->tiempo_alq = $tiempo_alq;
        $cuenta_host->facturado = $facturado;
        $cuenta_host->estado = $estado;
        $cuenta_host->created_at = $created_at;
        $cuenta_host->updated_at = $updated_at;

        $status = $cuenta_host->save();

        $id = $cuenta_host->id;

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
        $cuenta_host = CuentaHost::find($id);
        $cuenta_host->id = $id;
        $cuenta_host->propietario_id = $propietario_id;
        $cuenta_host->plan_id = $plan_id;
        $cuenta_host->dominio = $dominio;
        $cuenta_host->descripcion = $descripcion;
        $cuenta_host->solo_host = $solo_host;
        $cuenta_host->tiempo_alq = $tiempo_alq;
        $cuenta_host->facturado = $facturado;
        $cuenta_host->created_at = $created_at;
        $cuenta_host->updated_at = $updated_at;

        $status = $cuenta_host->save();

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

      $data = CuentaHost::find($id);

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
      $cuenta_host = CuentaHost::find( id ) ;

      if (empty($cuenta_host))
      {
        $cuenta_host = new CuentaHost();
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $cuenta_host->estado = 1;
          $cuenta_host->save();

          $status = true;
          $message = "Registro Eliminado";

        }elseif( $historial == "no"  ) {
          $cuenta_host->forceDelete();

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
        $cuenta_host = CuentaHost::find($id);
        $cuenta_host->estado = $estado;

        $status = $cuenta_host->save();

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

      $data = CuentaHost::where("estado", $estado)->get();

      return $data;

    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}