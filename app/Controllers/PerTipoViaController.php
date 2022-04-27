<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\PerTipoVia; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PerTipoViaController
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

      $data = PerTipoVia::get();

      return view($this->prefixView.'.per-tipo-vias.list-per-tipo-vias')->with(compact('data'));
    
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

      $data = PerTipoVia::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.per-tipo-vias.list-table-per-tipo-vias')->with(compact('data'));
    
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
        return view($this->prefixView.'.per-tipo-vias.form-create-per-tipo-via');
      }

      return view($this->prefixView.'.per-tipo-vias.new-per-tipo-via');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(PerTipoViaStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $cod_tv = $request->input('cod_tv');
      $abrv_via = $request->input('abrv_via');
      $descripcion = $request->input('descripcion');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $per_tipo_via = new PerTipoVia();
        $per_tipo_via->cod_tv = $cod_tv;
        $per_tipo_via->abrv_via = $abrv_via;
        $per_tipo_via->descripcion = $descripcion;
        $per_tipo_via->estado = $estado;
        
        $success = $per_tipo_via->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $per_tipo_via, "created") ;
        
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
    
      return redirect()->route('admin.per-tipo-vias');
    
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

      $per_tipo_via = PerTipoVia::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.per-tipo-vias.form-edit-per-tipo-via')->with(compact('per_tipo_via'));
      }

      return view($this->prefixView.'.per-tipo-vias.edit-per-tipo-via')->with(compact('per_tipo_via'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function update(PerTipoViaUpdateRequest $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id = $request->input('id');
      $cod_tv = $request->input('cod_tv');
      $abrv_via = $request->input('abrv_via');
      $descripcion = $request->input('descripcion');

      if (!empty($id))
      {
        $per_tipo_via = PerTipoVia::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $per_tipo_via->getAttributes();

        $per_tipo_via->id = $id;
        $per_tipo_via->cod_tv = $cod_tv;
        $per_tipo_via->abrv_via = $abrv_via;
        $per_tipo_via->descripcion = $descripcion;
        
        $success = $per_tipo_via->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $per_tipo_via, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.per-tipo-vias');
    
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

      $per_tipo_via = PerTipoVia::find( $id ) ;

      if (!empty($per_tipo_via))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $per_tipo_via->getAttributes();

        $per_tipo_via->estado = $estado;
        $per_tipo_via->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $per_tipo_via, "update estado", $attributes_old) ;
        
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

      $per_tipo_via = PerTipoVia::find( $id ) ;

      if (!empty($per_tipo_via))
      {

        $per_tipo_via->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $per_tipo_via, "destroy") ;
        
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

      $data = PerTipoVia::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}