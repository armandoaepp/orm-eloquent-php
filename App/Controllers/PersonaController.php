<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Persona; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PersonaController
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

      $data = Persona::get();

      return view($this->prefixView.'.personas.list-personas')->with(compact('data'));
    
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

      return view($this->prefixView.'.personas.new-persona');
    
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

      $per_id_padre = $request->input('per_id_padre');
      $per_nombre = $request->input('per_nombre');
      $per_apellidos = $request->input('per_apellidos');
      $per_fecha_nac = $request->input('per_fecha_nac');
      $per_tipo = $request->input('per_tipo');
      $per_estado = !empty($request->input('per_estado')) ? $request->input('per_estado') : 1;

      $persona = Persona::where(["per_id_padre" => $per_id_padre])->first();

      if (empty($persona))
      {

        $persona = new Persona();
        $persona->per_id_padre = $per_id_padre;
        $persona->per_nombre = $per_nombre;
        $persona->per_apellidos = $per_apellidos;
        $persona->per_fecha_nac = $per_fecha_nac;
        $persona->per_tipo = $per_tipo;
        $persona->per_estado = $per_estado;
        
        $status = $persona->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona, "created") ;
        
        $id = $persona->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$persona],];
    
      return redirect()->route('admin-personas');
    
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

      $persona = Persona::find( $id );

      return view($this->prefixView.'.personas.edit-persona')->with(compact('persona'));
    
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
      $per_id_padre = $request->input('per_id_padre');
      $per_nombre = $request->input('per_nombre');
      $per_apellidos = $request->input('per_apellidos');
      $per_fecha_nac = $request->input('per_fecha_nac');
      $per_tipo = $request->input('per_tipo');

      if (!empty($id))
      {
        $persona = Persona::find($id);
        $persona->id = $id;
        $persona->per_id_padre = $per_id_padre;
        $persona->per_nombre = $per_nombre;
        $persona->per_apellidos = $per_apellidos;
        $persona->per_fecha_nac = $per_fecha_nac;
        $persona->per_tipo = $per_tipo;
        
        $status = $persona->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-personas');;
    
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

      $persona = Persona::find( $id ) ;

      if (!empty($persona))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $persona->per_estado = $estado;
          $persona->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $persona, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $persona->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $persona, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $persona;
        
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

      $data = Persona::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}