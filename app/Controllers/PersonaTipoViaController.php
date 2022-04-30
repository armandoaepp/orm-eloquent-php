<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\PersonaTipoVia; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PersonaTipoViaController
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

      $data = PersonaTipoVia::get();

      return view($this->prefixView.'.persona-tipo-vias.list-persona-tipo-vias')->with(compact('data'));
    
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

      $data = PersonaTipoVia::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.persona-tipo-vias.list-table-persona-tipo-vias')->with(compact('data'));
    
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
        return view($this->prefixView.'.persona-tipo-vias.form-create-persona-tipo-via');
      }

      return view($this->prefixView.'.persona-tipo-vias.new-persona-tipo-via');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(PersonaTipoViaStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $cod_tv = $request->input('cod_tv');
      $abreviatura = $request->input('abreviatura');
      $descripcion = $request->input('descripcion');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $persona_tipo_via = new PersonaTipoVia();
        $persona_tipo_via->cod_tv = $cod_tv;
        $persona_tipo_via->abreviatura = $abreviatura;
        $persona_tipo_via->descripcion = $descripcion;
        $persona_tipo_via->estado = $estado;
        
        $success = $persona_tipo_via->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_tipo_via, "created") ;
        
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
    
      return redirect()->route('admin.persona-tipo-vias');
    
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

      $persona_tipo_via = PersonaTipoVia::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.persona-tipo-vias.form-edit-persona-tipo-via')->with(compact('persona_tipo_via'));
      }

      return view($this->prefixView.'.persona-tipo-vias.edit-persona-tipo-via')->with(compact('persona_tipo_via'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function update(PersonaTipoViaUpdateRequest $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id = $request->input('id');
      $cod_tv = $request->input('cod_tv');
      $abreviatura = $request->input('abreviatura');
      $descripcion = $request->input('descripcion');

      if (!empty($id))
      {
        $persona_tipo_via = PersonaTipoVia::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $persona_tipo_via->getAttributes();

        $persona_tipo_via->id = $id;
        $persona_tipo_via->cod_tv = $cod_tv;
        $persona_tipo_via->abreviatura = $abreviatura;
        $persona_tipo_via->descripcion = $descripcion;
        
        $success = $persona_tipo_via->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_tipo_via, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.persona-tipo-vias');
    
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

      $persona_tipo_via = PersonaTipoVia::find( $id ) ;

      if (!empty($persona_tipo_via))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $persona_tipo_via->getAttributes();

        $persona_tipo_via->estado = $estado;
        $persona_tipo_via->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_tipo_via, "update estado", $attributes_old) ;
        
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

      $persona_tipo_via = PersonaTipoVia::find( $id ) ;

      if (!empty($persona_tipo_via))
      {

        $persona_tipo_via->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_tipo_via, "destroy") ;
        
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

      $data = PersonaTipoVia::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}