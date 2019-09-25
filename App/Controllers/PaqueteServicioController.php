<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\PaqueteServicio; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PaqueteServicioController
{
  use BitacoraTrait, UploadFiles;

  protected $prefixView = "admin";

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function getAll()
  {
    try
    {

      $data = PaqueteServicio::get();

      return view($this->prefixView.'.paquete-servicios.list-paquete-servicios')->with(compact('data'));
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function create( Request $request )
  {
    try
    {

      return view($this->prefixView.'.paquete-servicios.new-paquete-servicio');
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function store( Request $request )
  {
    try
    {
      $status  = false;
      $message = "";

      $paquete_id = $request->input('paquete_id');
      $servicio_id = $request->input('servicio_id');
      $ps_horas = $request->input('ps_horas');
      $ps_estado = !empty($request->input('ps_estado')) ? $request->input('ps_estado') : 1;

      $paquete_servicio = PaqueteServicio::where(["paquete_id" => $paquete_id])->first();

      if (empty($paquete_servicio))
      {

        $paquete_servicio = new PaqueteServicio();
        $paquete_servicio->paquete_id = $paquete_id;
        $paquete_servicio->servicio_id = $servicio_id;
        $paquete_servicio->ps_horas = $ps_horas;
        $paquete_servicio->ps_estado = $ps_estado;
        
        $status = $paquete_servicio->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $paquete_servicio, "created") ;
        
        $id = $paquete_servicio->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$paquete_servicio],];
    
      return redirect()->route('admin-paquete-servicios');
    
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

      $paquete_servicio = PaqueteServicio::find( $id );

      return view($this->prefixView.'.paquete-servicios.edit-paquete-servicio')->with(compact('paquete_servicio'));
    
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
      $paquete_id = $request->input('paquete_id');
      $servicio_id = $request->input('servicio_id');
      $ps_horas = $request->input('ps_horas');

      if (!empty($id))
      {
        $paquete_servicio = PaqueteServicio::find($id);
        $paquete_servicio->id = $id;
        $paquete_servicio->paquete_id = $paquete_id;
        $paquete_servicio->servicio_id = $servicio_id;
        $paquete_servicio->ps_horas = $ps_horas;
        
        $status = $paquete_servicio->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $paquete_servicio, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-paquete-servicios');;
    
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

      $paquete_servicio = PaqueteServicio::find( $id ) ;

      if (!empty($paquete_servicio))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $paquete_servicio->ps_estado = $estado;
          $paquete_servicio->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $paquete_servicio, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $paquete_servicio->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $paquete_servicio, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $paquete_servicio;
        
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
                "status"  => false,
                "errors"  => [$e->getMessage(), ],
                "data"    => [],
              ]);
    }

  }

  public function find( $id )
  {
    try
    {

      $data = PaqueteServicio::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}