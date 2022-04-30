<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\PersonaJuridica; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PersonaJuridicaController
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

      $data = PersonaJuridica::get();

      return view($this->prefixView.'.persona-juridicas.list-persona-juridicas')->with(compact('data'));
    
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

      $data = PersonaJuridica::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.persona-juridicas.list-table-persona-juridicas')->with(compact('data'));
    
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
        return view($this->prefixView.'.persona-juridicas.form-create-persona-juridica');
      }

      return view($this->prefixView.'.persona-juridicas.new-persona-juridica');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(PersonaJuridicaStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $persona_id = $request->input('persona_id');
      $ruc = $request->input('ruc');
      $razon_social = $request->input('razon_social');
      $nombre_comercial = $request->input('nombre_comercial');
      $observacion = $request->input('observacion');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $persona_juridica = new PersonaJuridica();
        $persona_juridica->persona_id = $persona_id;
        $persona_juridica->ruc = $ruc;
        $persona_juridica->razon_social = $razon_social;
        $persona_juridica->nombre_comercial = $nombre_comercial;
        $persona_juridica->observacion = $observacion;
        $persona_juridica->estado = $estado;
        
        $success = $persona_juridica->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_juridica, "created") ;
        
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
    
      return redirect()->route('admin.persona-juridicas');
    
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

      $persona_juridica = PersonaJuridica::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.persona-juridicas.form-edit-persona-juridica')->with(compact('persona_juridica'));
      }

      return view($this->prefixView.'.persona-juridicas.edit-persona-juridica')->with(compact('persona_juridica'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function update(PersonaJuridicaUpdateRequest $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id = $request->input('id');
      $persona_id = $request->input('persona_id');
      $ruc = $request->input('ruc');
      $razon_social = $request->input('razon_social');
      $nombre_comercial = $request->input('nombre_comercial');
      $observacion = $request->input('observacion');

      if (!empty($id))
      {
        $persona_juridica = PersonaJuridica::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $persona_juridica->getAttributes();

        $persona_juridica->id = $id;
        $persona_juridica->persona_id = $persona_id;
        $persona_juridica->ruc = $ruc;
        $persona_juridica->razon_social = $razon_social;
        $persona_juridica->nombre_comercial = $nombre_comercial;
        $persona_juridica->observacion = $observacion;
        
        $success = $persona_juridica->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_juridica, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.persona-juridicas');
    
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

      $persona_juridica = PersonaJuridica::find( $id ) ;

      if (!empty($persona_juridica))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $persona_juridica->getAttributes();

        $persona_juridica->estado = $estado;
        $persona_juridica->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_juridica, "update estado", $attributes_old) ;
        
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

      $persona_juridica = PersonaJuridica::find( $id ) ;

      if (!empty($persona_juridica))
      {

        $persona_juridica->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_juridica, "destroy") ;
        
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

      $data = PersonaJuridica::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}