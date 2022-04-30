<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\PersonaTipoIdentidad; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PersonaTipoIdentidadController
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

      $data = PersonaTipoIdentidad::get();

      return view($this->prefixView.'.persona-tipo-identidads.list-persona-tipo-identidads')->with(compact('data'));
    
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

      $data = PersonaTipoIdentidad::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.persona-tipo-identidads.list-table-persona-tipo-identidads')->with(compact('data'));
    
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
        return view($this->prefixView.'.persona-tipo-identidads.form-create-persona-tipo-identidad');
      }

      return view($this->prefixView.'.persona-tipo-identidads.new-persona-tipo-identidad');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(PersonaTipoIdentidadStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $cod_ti = $request->input('cod_ti');
      $abreviatura = $request->input('abreviatura');
      $descripcion = $request->input('descripcion');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $persona_tipo_identidad = new PersonaTipoIdentidad();
        $persona_tipo_identidad->cod_ti = $cod_ti;
        $persona_tipo_identidad->abreviatura = $abreviatura;
        $persona_tipo_identidad->descripcion = $descripcion;
        $persona_tipo_identidad->estado = $estado;
        
        $success = $persona_tipo_identidad->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_tipo_identidad, "created") ;
        
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
    
      return redirect()->route('admin.persona-tipo-identidads');
    
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

      $persona_tipo_identidad = PersonaTipoIdentidad::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.persona-tipo-identidads.form-edit-persona-tipo-identidad')->with(compact('persona_tipo_identidad'));
      }

      return view($this->prefixView.'.persona-tipo-identidads.edit-persona-tipo-identidad')->with(compact('persona_tipo_identidad'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function update(PersonaTipoIdentidadUpdateRequest $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id = $request->input('id');
      $cod_ti = $request->input('cod_ti');
      $abreviatura = $request->input('abreviatura');
      $descripcion = $request->input('descripcion');

      if (!empty($id))
      {
        $persona_tipo_identidad = PersonaTipoIdentidad::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $persona_tipo_identidad->getAttributes();

        $persona_tipo_identidad->id = $id;
        $persona_tipo_identidad->cod_ti = $cod_ti;
        $persona_tipo_identidad->abreviatura = $abreviatura;
        $persona_tipo_identidad->descripcion = $descripcion;
        
        $success = $persona_tipo_identidad->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_tipo_identidad, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.persona-tipo-identidads');
    
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

      $persona_tipo_identidad = PersonaTipoIdentidad::find( $id ) ;

      if (!empty($persona_tipo_identidad))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $persona_tipo_identidad->getAttributes();

        $persona_tipo_identidad->estado = $estado;
        $persona_tipo_identidad->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_tipo_identidad, "update estado", $attributes_old) ;
        
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

      $persona_tipo_identidad = PersonaTipoIdentidad::find( $id ) ;

      if (!empty($persona_tipo_identidad))
      {

        $persona_tipo_identidad->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_tipo_identidad, "destroy") ;
        
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

      $data = PersonaTipoIdentidad::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}