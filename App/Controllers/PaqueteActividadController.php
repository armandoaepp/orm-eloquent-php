<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\PaqueteActividad; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PaqueteActividadController
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

      $data = PaqueteActividad::get();

      return view($this->prefixView.'.paquete-actividads.list-paquete-actividads')->with(compact('data'));
    
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

      return view($this->prefixView.'.paquete-actividads.new-paquete-actividad');
    
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
      $actividad_id = $request->input('actividad_id');
      $pa_horas = $request->input('pa_horas');
      $pa_estado = !empty($request->input('pa_estado')) ? $request->input('pa_estado') : 1;

      $paquete_actividad = PaqueteActividad::where(["paquete_id" => $paquete_id])->first();

      if (empty($paquete_actividad))
      {

        $paquete_actividad = new PaqueteActividad();
        $paquete_actividad->paquete_id = $paquete_id;
        $paquete_actividad->actividad_id = $actividad_id;
        $paquete_actividad->pa_horas = $pa_horas;
        $paquete_actividad->pa_estado = $pa_estado;
        
        $status = $paquete_actividad->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $paquete_actividad, "created") ;
        
        $id = $paquete_actividad->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$paquete_actividad],];
    
      return redirect()->route('admin-paquete-actividads');
    
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

      $paquete_actividad = PaqueteActividad::find( $id );

      return view($this->prefixView.'.paquete-actividads.edit-paquete-actividad')->with(compact('paquete_actividad'));
    
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
      $actividad_id = $request->input('actividad_id');
      $pa_horas = $request->input('pa_horas');

      if (!empty($id))
      {
        $paquete_actividad = PaqueteActividad::find($id);
        $paquete_actividad->id = $id;
        $paquete_actividad->paquete_id = $paquete_id;
        $paquete_actividad->actividad_id = $actividad_id;
        $paquete_actividad->pa_horas = $pa_horas;
        
        $status = $paquete_actividad->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $paquete_actividad, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-paquete-actividads');;
    
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

      $paquete_actividad = PaqueteActividad::find( $id ) ;

      if (!empty($paquete_actividad))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $paquete_actividad->pa_estado = $estado;
          $paquete_actividad->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $paquete_actividad, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $paquete_actividad->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $paquete_actividad, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $paquete_actividad;
        
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

      $data = PaqueteActividad::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}