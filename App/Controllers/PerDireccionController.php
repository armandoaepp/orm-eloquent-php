<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\PerDireccion; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PerDireccionController
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

      $data = PerDireccion::get();

      return view($this->prefixView.'.per-direccions.list-per-direccions')->with(compact('data'));
    
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

      return view($this->prefixView.'.per-direccions.new-per-direccion');
    
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

      $persona_id = $request->input('persona_id');
      $tipo_direccion_id = $request->input('tipo_direccion_id');
      $ubigeo_id = $request->input('ubigeo_id');
      $pd_jerarquia = $request->input('pd_jerarquia');
      $pd_direccion = $request->input('pd_direccion');
      $pd_referencia = $request->input('pd_referencia');
      $pd_estado = !empty($request->input('pd_estado')) ? $request->input('pd_estado') : 1;

      $per_direccion = PerDireccion::where(["persona_id" => $persona_id])->first();

      if (empty($per_direccion))
      {

        $per_direccion = new PerDireccion();
        $per_direccion->persona_id = $persona_id;
        $per_direccion->tipo_direccion_id = $tipo_direccion_id;
        $per_direccion->ubigeo_id = $ubigeo_id;
        $per_direccion->pd_jerarquia = $pd_jerarquia;
        $per_direccion->pd_direccion = $pd_direccion;
        $per_direccion->pd_referencia = $pd_referencia;
        $per_direccion->pd_estado = $pd_estado;
        
        $status = $per_direccion->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $per_direccion, "created") ;
        
        $id = $per_direccion->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$per_direccion],];
    
      return redirect()->route('admin-per-direccions');
    
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

      $per_direccion = PerDireccion::find( $id );

      return view($this->prefixView.'.per-direccions.edit-per-direccion')->with(compact('per_direccion'));
    
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
      $persona_id = $request->input('persona_id');
      $tipo_direccion_id = $request->input('tipo_direccion_id');
      $ubigeo_id = $request->input('ubigeo_id');
      $pd_jerarquia = $request->input('pd_jerarquia');
      $pd_direccion = $request->input('pd_direccion');
      $pd_referencia = $request->input('pd_referencia');

      if (!empty($id))
      {
        $per_direccion = PerDireccion::find($id);
        $per_direccion->id = $id;
        $per_direccion->persona_id = $persona_id;
        $per_direccion->tipo_direccion_id = $tipo_direccion_id;
        $per_direccion->ubigeo_id = $ubigeo_id;
        $per_direccion->pd_jerarquia = $pd_jerarquia;
        $per_direccion->pd_direccion = $pd_direccion;
        $per_direccion->pd_referencia = $pd_referencia;
        
        $status = $per_direccion->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $per_direccion, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-per-direccions');;
    
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

      $per_direccion = PerDireccion::find( $id ) ;

      if (!empty($per_direccion))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $per_direccion->pd_estado = $estado;
          $per_direccion->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $per_direccion, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $per_direccion->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $per_direccion, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $per_direccion;
        
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

      $data = PerDireccion::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}