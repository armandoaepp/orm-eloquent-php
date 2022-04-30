<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\PersonaTelefono; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PersonaTelefonoController
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

      $data = PersonaTelefono::get();

      return view($this->prefixView.'.persona-telefonos.list-persona-telefonos')->with(compact('data'));
    
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

      $data = PersonaTelefono::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.persona-telefonos.list-table-persona-telefonos')->with(compact('data'));
    
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
        return view($this->prefixView.'.persona-telefonos.form-create-persona-telefono');
      }

      return view($this->prefixView.'.persona-telefonos.new-persona-telefono');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(PersonaTelefonoStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $persona_id = $request->input('persona_id');
      $tipo_telefono_id = $request->input('tipo_telefono_id');
      $telefono = $request->input('telefono');
      $observación = $request->input('observación');
      $is_principal = $request->input('is_principal');
      $jerarquia = $request->input('jerarquia');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $persona_telefono = new PersonaTelefono();
        $persona_telefono->persona_id = $persona_id;
        $persona_telefono->tipo_telefono_id = $tipo_telefono_id;
        $persona_telefono->telefono = $telefono;
        $persona_telefono->observación = $observación;
        $persona_telefono->is_principal = $is_principal;
        $persona_telefono->jerarquia = $jerarquia;
        $persona_telefono->estado = $estado;
        
        $success = $persona_telefono->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_telefono, "created") ;
        
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
    
      return redirect()->route('admin.persona-telefonos');
    
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

      $persona_telefono = PersonaTelefono::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.persona-telefonos.form-edit-persona-telefono')->with(compact('persona_telefono'));
      }

      return view($this->prefixView.'.persona-telefonos.edit-persona-telefono')->with(compact('persona_telefono'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function update(PersonaTelefonoUpdateRequest $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id = $request->input('id');
      $persona_id = $request->input('persona_id');
      $tipo_telefono_id = $request->input('tipo_telefono_id');
      $telefono = $request->input('telefono');
      $observación = $request->input('observación');
      $is_principal = $request->input('is_principal');
      $jerarquia = $request->input('jerarquia');

      if (!empty($id))
      {
        $persona_telefono = PersonaTelefono::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $persona_telefono->getAttributes();

        $persona_telefono->id = $id;
        $persona_telefono->persona_id = $persona_id;
        $persona_telefono->tipo_telefono_id = $tipo_telefono_id;
        $persona_telefono->telefono = $telefono;
        $persona_telefono->observación = $observación;
        $persona_telefono->is_principal = $is_principal;
        $persona_telefono->jerarquia = $jerarquia;
        
        $success = $persona_telefono->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_telefono, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.persona-telefonos');
    
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

      $persona_telefono = PersonaTelefono::find( $id ) ;

      if (!empty($persona_telefono))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $persona_telefono->getAttributes();

        $persona_telefono->estado = $estado;
        $persona_telefono->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_telefono, "update estado", $attributes_old) ;
        
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

      $persona_telefono = PersonaTelefono::find( $id ) ;

      if (!empty($persona_telefono))
      {

        $persona_telefono->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_telefono, "destroy") ;
        
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

      $data = PersonaTelefono::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}