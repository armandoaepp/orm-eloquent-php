<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\TipoCambio; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class TipoCambioController
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

      $data = TipoCambio::get();

      return view($this->prefixView.'.tipo-cambios.list-tipo-cambios')->with(compact('data'));
    
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

      $data = TipoCambio::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.tipo-cambios.list-table-tipo-cambios')->with(compact('data'));
    
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
        return view($this->prefixView.'.tipo-cambios.form-create-tipo-cambio');
      }

      return view($this->prefixView.'.tipo-cambios.new-tipo-cambio');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(TipoCambioStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $fecha = $request->input('fecha');
      $valor = $request->input('valor');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $tipo_cambio = new TipoCambio();
        $tipo_cambio->fecha = $fecha;
        $tipo_cambio->valor = $valor;
        $tipo_cambio->estado = $estado;
        
        $success = $tipo_cambio->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_cambio, "created") ;
        
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
    
      return redirect()->route('admin.tipo-cambios');
    
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

      $tipo_cambio = TipoCambio::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.tipo-cambios.form-edit-tipo-cambio')->with(compact('tipo_cambio'));
      }

      return view($this->prefixView.'.tipo-cambios.edit-tipo-cambio')->with(compact('tipo_cambio'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function update(TipoCambioUpdateRequest $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id = $request->input('id');
      $fecha = $request->input('fecha');
      $valor = $request->input('valor');

      if (!empty($id))
      {
        $tipo_cambio = TipoCambio::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $tipo_cambio->getAttributes();

        $tipo_cambio->id = $id;
        $tipo_cambio->fecha = $fecha;
        $tipo_cambio->valor = $valor;
        
        $success = $tipo_cambio->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_cambio, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.tipo-cambios');
    
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

      $tipo_cambio = TipoCambio::find( $id ) ;

      if (!empty($tipo_cambio))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $tipo_cambio->getAttributes();

        $tipo_cambio->estado = $estado;
        $tipo_cambio->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_cambio, "update estado", $attributes_old) ;
        
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

      $tipo_cambio = TipoCambio::find( $id ) ;

      if (!empty($tipo_cambio))
      {

        $tipo_cambio->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_cambio, "destroy") ;
        
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

      $data = TipoCambio::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}