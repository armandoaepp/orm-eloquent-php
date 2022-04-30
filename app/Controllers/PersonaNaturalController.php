<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\PersonaNatural; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PersonaNaturalController
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

      $data = PersonaNatural::get();

      return view($this->prefixView.'.persona-naturals.list-persona-naturals')->with(compact('data'));
    
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

      $data = PersonaNatural::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.persona-naturals.list-table-persona-naturals')->with(compact('data'));
    
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
        return view($this->prefixView.'.persona-naturals.form-create-persona-natural');
      }

      return view($this->prefixView.'.persona-naturals.new-persona-natural');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(PersonaNaturalStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $persona_id = $request->input('persona_id');
      $tipo_identidad_id = $request->input('tipo_identidad_id');
      $num_doc = $request->input('num_doc');
      $ape_paterno = $request->input('ape_paterno');
      $ape_materno = $request->input('ape_materno');
      $nombres = $request->input('nombres');
      $full_name = $request->input('full_name');
      $sexo = $request->input('sexo');
      $estado_civil_id = $request->input('estado_civil_id');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $persona_natural = new PersonaNatural();
        $persona_natural->persona_id = $persona_id;
        $persona_natural->tipo_identidad_id = $tipo_identidad_id;
        $persona_natural->num_doc = $num_doc;
        $persona_natural->ape_paterno = $ape_paterno;
        $persona_natural->ape_materno = $ape_materno;
        $persona_natural->nombres = $nombres;
        $persona_natural->full_name = $full_name;
        $persona_natural->sexo = $sexo;
        $persona_natural->estado_civil_id = $estado_civil_id;
        $persona_natural->estado = $estado;
        
        $success = $persona_natural->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_natural, "created") ;
        
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
    
      return redirect()->route('admin.persona-naturals');
    
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

      $persona_natural = PersonaNatural::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.persona-naturals.form-edit-persona-natural')->with(compact('persona_natural'));
      }

      return view($this->prefixView.'.persona-naturals.edit-persona-natural')->with(compact('persona_natural'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function update(PersonaNaturalUpdateRequest $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id = $request->input('id');
      $persona_id = $request->input('persona_id');
      $tipo_identidad_id = $request->input('tipo_identidad_id');
      $num_doc = $request->input('num_doc');
      $ape_paterno = $request->input('ape_paterno');
      $ape_materno = $request->input('ape_materno');
      $nombres = $request->input('nombres');
      $full_name = $request->input('full_name');
      $sexo = $request->input('sexo');
      $estado_civil_id = $request->input('estado_civil_id');

      if (!empty($id))
      {
        $persona_natural = PersonaNatural::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $persona_natural->getAttributes();

        $persona_natural->id = $id;
        $persona_natural->persona_id = $persona_id;
        $persona_natural->tipo_identidad_id = $tipo_identidad_id;
        $persona_natural->num_doc = $num_doc;
        $persona_natural->ape_paterno = $ape_paterno;
        $persona_natural->ape_materno = $ape_materno;
        $persona_natural->nombres = $nombres;
        $persona_natural->full_name = $full_name;
        $persona_natural->sexo = $sexo;
        $persona_natural->estado_civil_id = $estado_civil_id;
        
        $success = $persona_natural->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_natural, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.persona-naturals');
    
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

      $persona_natural = PersonaNatural::find( $id ) ;

      if (!empty($persona_natural))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $persona_natural->getAttributes();

        $persona_natural->estado = $estado;
        $persona_natural->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_natural, "update estado", $attributes_old) ;
        
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

      $persona_natural = PersonaNatural::find( $id ) ;

      if (!empty($persona_natural))
      {

        $persona_natural->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_natural, "destroy") ;
        
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

      $data = PersonaNatural::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}