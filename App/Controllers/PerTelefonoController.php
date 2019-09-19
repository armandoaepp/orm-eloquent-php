<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\PerTelefono; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PerTelefonoController
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

      $data = PerTelefono::get();

      return view($this->prefixView.'.per-telefonos.list-per-telefonos')->with(compact('data'));
    
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

      return view($this->prefixView.'.per-telefonos.new-per-telefono');
    
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

      $tipo_telefono_id = $request->input('tipo_telefono_id');
      $pt_jerarquia = $request->input('pt_jerarquia');
      $pt_telefono = $request->input('pt_telefono');
      $pt_estado = !empty($request->input('pt_estado')) ? $request->input('pt_estado') : 1;

      $per_telefono = PerTelefono::where(["tipo_telefono_id" => $tipo_telefono_id])->first();

      if (empty($per_telefono))
      {

        $per_telefono = new PerTelefono();
        $per_telefono->tipo_telefono_id = $tipo_telefono_id;
        $per_telefono->pt_jerarquia = $pt_jerarquia;
        $per_telefono->pt_telefono = $pt_telefono;
        $per_telefono->pt_estado = $pt_estado;
        
        $status = $per_telefono->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $per_telefono, "created") ;
        
        $id = $per_telefono->persona_id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$per_telefono],];
    
      return redirect()->route('admin-per-telefonos');
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function edit( $persona_id )
  {
    try
    {

      $per_telefono = PerTelefono::find( $persona_id );

      return view($this->prefixView.'.per-telefonos.edit-per-telefono')->with(compact('per_telefono'));
    
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

      $persona_id = $request->input('persona_id');
      $tipo_telefono_id = $request->input('tipo_telefono_id');
      $pt_jerarquia = $request->input('pt_jerarquia');
      $pt_telefono = $request->input('pt_telefono');

      if (!empty($persona_id))
      {
        $per_telefono = PerTelefono::find($persona_id);
        $per_telefono->persona_id = $persona_id;
        $per_telefono->tipo_telefono_id = $tipo_telefono_id;
        $per_telefono->pt_jerarquia = $pt_jerarquia;
        $per_telefono->pt_telefono = $pt_telefono;
        
        $status = $per_telefono->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $per_telefono, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-per-telefonos');;
    
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

      $per_telefono = PerTelefono::find( $persona_id ) ;

      if (!empty($per_telefono))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $per_telefono->pt_estado = $estado;
          $per_telefono->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $per_telefono, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $per_telefono->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $per_telefono, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $per_telefono;
        
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

  public function find( $persona_id )
  {
    try
    {

      $data = PerTelefono::find($persona_id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}