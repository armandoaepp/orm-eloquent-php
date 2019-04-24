<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/;

use App\Models\CuentaHost; 

class CuentaHostController
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function getAll()
  {
    try
    {

      $data = CuentaHost::get();

      return view('admin.cuenta-hosts.list-cuenta-hosts')->with(compact('data'));
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function newRegister( Request $request )
  {
    try
    {

      return view('admin.cuenta-hosts.new-cuenta-host');
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function save( Request $request )
  {
    try
    {
      $status  = false;
      $message = "";

      $propietario_id = $request->input('propietario_id');
      $plan_id = $request->input('plan_id');
      $dominio = $request->input('dominio');
      $descripcion = $request->input('descripcion');
      $solo_host = $request->input('solo_host');
      $tiempo_alq = $request->input('tiempo_alq');
      $facturado = $request->input('facturado');
      $estado = $request->input('estado');

      $cuenta_host = CuentaHost::where(["propietario_id" => $propietario_id])->first();

      if (empty($cuenta_host))
      {
        $cuenta_host = new CuentaHost();
        $cuenta_host->propietario_id = $propietario_id;
        $cuenta_host->plan_id = $plan_id;
        $cuenta_host->dominio = $dominio;
        $cuenta_host->descripcion = $descripcion;
        $cuenta_host->solo_host = $solo_host;
        $cuenta_host->tiempo_alq = $tiempo_alq;
        $cuenta_host->facturado = $facturado;
        $cuenta_host->estado = $estado;
        
        $status = $cuenta_host->save();
        
        $id = $cuenta_host->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$cuenta_host],];
    
      return redirect()->route('admin-cuenta-hosts');
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function edit( $id )
  {
    try
    {

      $data = CuentaHost::find($id);

      return view('admin.cuenta-hosts.edit-cuenta-host')->with(compact('data'));
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function update( Request $request )
  {
    try
    {

      $status  = false;
      $message = "";

      $id = $request->input('id');
      $propietario_id = $request->input('propietario_id');
      $plan_id = $request->input('plan_id');
      $dominio = $request->input('dominio');
      $descripcion = $request->input('descripcion');
      $solo_host = $request->input('solo_host');
      $tiempo_alq = $request->input('tiempo_alq');
      $facturado = $request->input('facturado');

      if (!empty($id))
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
        
        $status = $cuenta_host->save();
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-cuenta-hosts');;
    
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

  public function delete( Request $request )
  {
    try
    {
      $status  = false;
      $message = "";

      $id = $request->input('id');
      $estado = $request->input('estado');
      $historial = !empty($request->input('historial')) ? $request->input('historial') : "si";

      if ($estado == 1) {
        $estado = 0;
      } else {
        $estado = 1;
      }

      $cuenta_host = CuentaHost::find( $id ) ;

      if (!empty($cuenta_host))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $cuenta_host->estado = $estado;
          $cuenta_host->save();
            
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $cuenta_host->forceDelete();
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
         $data = $plan;
        
      }
      else
      {
        $message = "¡El registro no exite o el identificador es incorrecto!";
        $data = $request->all();
      }
    
      return \Response::json([
                "message" => $message,
                "status"  => $status,
                "errors"  => [],
                "data"    => [$data],
              ]);
    
    }
    catch (\Throwable $e) 
    {
      return \Response::json([
                "message" => "Operación fallida en el servidor",
                "status"  => $status,
                "errors"  => [$e->getMessage(), ],
                "data"    => [],
              ]);
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