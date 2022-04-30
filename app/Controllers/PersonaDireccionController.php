<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\PersonaDireccion; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PersonaDireccionController
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

      $data = PersonaDireccion::get();

      return view($this->prefixView.'.persona-direccions.list-persona-direccions')->with(compact('data'));
    
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

      $data = PersonaDireccion::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.persona-direccions.list-table-persona-direccions')->with(compact('data'));
    
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
        return view($this->prefixView.'.persona-direccions.form-create-persona-direccion');
      }

      return view($this->prefixView.'.persona-direccions.new-persona-direccion');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(PersonaDireccionStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $persona_id = $request->input('persona_id');
      $tipo_via_id = $request->input('tipo_via_id');
      $ubigeo_id = $request->input('ubigeo_id');
      $direccion = $request->input('direccion');
      $referencia = $request->input('referencia');
      $is_principal = $request->input('is_principal');
      $jerarquia = $request->input('jerarquia');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $persona_direccion = new PersonaDireccion();
        $persona_direccion->persona_id = $persona_id;
        $persona_direccion->tipo_via_id = $tipo_via_id;
        $persona_direccion->ubigeo_id = $ubigeo_id;
        $persona_direccion->direccion = $direccion;
        $persona_direccion->referencia = $referencia;
        $persona_direccion->is_principal = $is_principal;
        $persona_direccion->jerarquia = $jerarquia;
        $persona_direccion->estado = $estado;
        
        $success = $persona_direccion->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_direccion, "created") ;
        
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
    
      return redirect()->route('admin.persona-direccions');
    
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

      $persona_direccion = PersonaDireccion::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.persona-direccions.form-edit-persona-direccion')->with(compact('persona_direccion'));
      }

      return view($this->prefixView.'.persona-direccions.edit-persona-direccion')->with(compact('persona_direccion'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function update(PersonaDireccionUpdateRequest $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id = $request->input('id');
      $persona_id = $request->input('persona_id');
      $tipo_via_id = $request->input('tipo_via_id');
      $ubigeo_id = $request->input('ubigeo_id');
      $direccion = $request->input('direccion');
      $referencia = $request->input('referencia');
      $is_principal = $request->input('is_principal');
      $jerarquia = $request->input('jerarquia');

      if (!empty($id))
      {
        $persona_direccion = PersonaDireccion::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $persona_direccion->getAttributes();

        $persona_direccion->id = $id;
        $persona_direccion->persona_id = $persona_id;
        $persona_direccion->tipo_via_id = $tipo_via_id;
        $persona_direccion->ubigeo_id = $ubigeo_id;
        $persona_direccion->direccion = $direccion;
        $persona_direccion->referencia = $referencia;
        $persona_direccion->is_principal = $is_principal;
        $persona_direccion->jerarquia = $jerarquia;
        
        $success = $persona_direccion->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_direccion, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.persona-direccions');
    
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

      $persona_direccion = PersonaDireccion::find( $id ) ;

      if (!empty($persona_direccion))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $persona_direccion->getAttributes();

        $persona_direccion->estado = $estado;
        $persona_direccion->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_direccion, "update estado", $attributes_old) ;
        
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

      $persona_direccion = PersonaDireccion::find( $id ) ;

      if (!empty($persona_direccion))
      {

        $persona_direccion->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_direccion, "destroy") ;
        
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

      $data = PersonaDireccion::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}