<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
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

  public function index()
  {
    try
    {

      $data = Persona::get();

      return view($this->prefixView.'.personas.list-personas')->with(compact('data'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function listTable(Request $request)
  {
    try
    {

      $data = Persona::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.personas.list-table-personas')->with(compact('data'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function create(Request $request )
  {
    try
    {

      if ($request->ajax()) {
        return view($this->prefixView.'.personas.form-create-persona');
      }

      return view($this->prefixView.'.personas.new-persona');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(PersonaStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $sede_id = $request->input('sede_id');
      $per_nombre = $request->input('per_nombre');
      $per_apellidos = $request->input('per_apellidos');
      $fecha_nac = $request->input('fecha_nac');
      $per_tipo = $request->input('per_tipo');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $persona = new Persona();
        $persona->sede_id = $sede_id;
        $persona->per_nombre = $per_nombre;
        $persona->per_apellidos = $per_apellidos;
        $persona->fecha_nac = $fecha_nac;
        $persona->per_tipo = $per_tipo;
        $persona->estado = $estado;
        
        $success = $persona->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $persona, "created") ;
        
      $message = "Datos Registrados Correctamente";
        
      if ($request->ajax()) {
        return response()->json([
          "message" => $message,
          "code"    => 200,
          "success"  => $success,
          "errors"  => [],
          "data"    => [],
        ]);
      };
    
      return redirect()->route('admin.personas');
    
    }
    catch (\Exception $e)
    {

      if ($request->ajax()) {
        return response()->json([
          "message" => "Operación fallida en el servidor",
          "code"    => 500,
          "success"  => false,
          "errors"  => [$e->getMessage()],
          "data"    => []
        ]);
      }

      throw new \Exception($e->getMessage());
    }

  }

  public function edit( $id, Request $request)
  {
    try
    {

      $persona = Persona::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.personas.form-edit-persona')->with(compact('persona'));
      }

      return view($this->prefixView.'.personas.edit-persona')->with(compact('persona'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function update(PersonaUpdateRequest $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id = $request->input('id');
      $sede_id = $request->input('sede_id');
      $per_nombre = $request->input('per_nombre');
      $per_apellidos = $request->input('per_apellidos');
      $fecha_nac = $request->input('fecha_nac');
      $per_tipo = $request->input('per_tipo');

      if (!empty($id))
      {
        $persona = Persona::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $persona->getAttributes();

        $persona->id = $id;
        $persona->sede_id = $sede_id;
        $persona->per_nombre = $per_nombre;
        $persona->per_apellidos = $per_apellidos;
        $persona->fecha_nac = $fecha_nac;
        $persona->per_tipo = $per_tipo;
        
        $success = $persona->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona, "update", $attributes_old) ;
        
        $message = "Datos Actualizados Correctamente";
        $code = 200;
        
      }
      else
      {
        $message = "¡El registro NO existe!";
        $code = 406;
      }

      if ($request->ajax()) {
        return response()->json([
          "message" => $message,
          "code"    => $code,
          "success"  => $success,
          "errors"  => [],
          "data"    => [],
        ]);
      };

      return redirect()->route('admin.personas');
    
    }
    catch (\Exception $e)
    {

      if ($request->ajax()) {
        return response()->json([
          "message" => "Operación fallida en el servidor",
          "code"    => 500,
          "success" => false,
          "errors"  => [$e->getMessage()],
          "data"    => []
        ]);
      }

      throw new \Exception($e->getMessage());
    }

  }

  public function delete(EstadoIdRequest $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id        = $request->input('id');
      $estado    = $request->input('estado');

      if ($estado == 1) {
        $message = "Registro Activado Correctamente";
      } else {
        $message = "Registro Desactivo Correctamente";
      }

      $persona = Persona::find( $id ) ;

      if (!empty($persona))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $persona->getAttributes();

        $persona->estado = $estado;
        $persona->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona, "update estado", $attributes_old) ;
        
        $success = true;
        $code = 200;
      } else {
        $message = "¡El registro no exite o el identificador es incorrecto!";
        $success  = false;
        $code = 400;
      }  
        
      if ($request->ajax()) {
        return response()->json([
          "message" => $message,
          "code"    => $code,
          "success" => $success,
          "errors"  => [],
          "data"    => [],
        ]);
      };
        
    }
    catch (\Throwable $e) 
    {

      if ($request->ajax()) {
        return response()->json([
          "message" => "Operación fallida en el servidor",
          "code"    => 500,
          "success"  => false,
          "errors"  => [$e->getMessage()],
          "data"    => []
        ]);
      }

      throw new \Exception($e->getMessage());
    }

  }

  public function destroy(Request $request )
  {
    try
    {
      $validator = \Validator::make($request->all(), [
        'id'     => 'numeric',
      ]);
      if ($validator->fails())
      {
        if ($request->ajax())
        {
          return response()->json([
            "message" => "Error al realizar operación",
            "code"    => 400,
            "success" => false,
            "errors"  => $validator->errors()->all(),
            "data"    => [],
            ]);
        }
      }


      $success = false;
      $message = "";

      $id = $request->input('id');

      $persona = Persona::find( $id ) ;

      if (!empty($persona))
      {

        $persona->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona, "destroy") ;
        
        $success = true;
        $code = 200;
        $message = "Registro Borrado Correctamente";
      } else {
        $message = "¡El registro no exite o el identificador es incorrecto!";
        $success  = false;
        $code = 400;
      }  
        
      if ($request->ajax()) {
        return response()->json([
          "message" => $message,
          "code"    => $code,
          "success" => $success,
          "errors"  => [],
          "data"    => [],
        ]);
      }
        
    }
    catch (\Throwable $e) 
    {

      if ($request->ajax()) {
        return response()->json([
          "message" => "Operación fallida en el servidor",
          "code"    => 500,
          "success" => false,
          "errors"  => [$e->getMessage()],
          "data"    => []
        ]);
      }

      throw new \Exception($e->getMessage());
    }

  }

  public function find( $id )
  {
    try
    {

      $data = Persona::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}