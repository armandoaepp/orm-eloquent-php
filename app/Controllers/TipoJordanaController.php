<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\TipoJordana; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class TipoJordanaController
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

      $data = TipoJordana::get();

      return view($this->prefixView.'.tipo-jordanas.list-tipo-jordanas')->with(compact('data'));
    
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

      $data = TipoJordana::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.tipo-jordanas.list-table-tipo-jordanas')->with(compact('data'));
    
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
        return view($this->prefixView.'.tipo-jordanas.form-create-tipo-jordana');
      }

      return view($this->prefixView.'.tipo-jordanas.new-tipo-jordana');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(TipoJordanaStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $cod_tj = $request->input('cod_tj');
      $descripcion = $request->input('descripcion');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $tipo_jordana = new TipoJordana();
        $tipo_jordana->cod_tj = $cod_tj;
        $tipo_jordana->descripcion = $descripcion;
        $tipo_jordana->estado = $estado;
        
        $success = $tipo_jordana->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_jordana, "created") ;
        
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
    
      return redirect()->route('admin.tipo-jordanas');
    
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

      $tipo_jordana = TipoJordana::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.tipo-jordanas.form-edit-tipo-jordana')->with(compact('tipo_jordana'));
      }

      return view($this->prefixView.'.tipo-jordanas.edit-tipo-jordana')->with(compact('tipo_jordana'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function update(Request $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id = $request->input('id');
      $cod_tj = $request->input('cod_tj');
      $descripcion = $request->input('descripcion');

      if (!empty($id))
      {
        $tipo_jordana = TipoJordana::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $tipo_jordana->getAttributes();
        $tipo_jordana->id = $id;
        $tipo_jordana->cod_tj = $cod_tj;
        $tipo_jordana->descripcion = $descripcion;
        
        $success = $tipo_jordana->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_jordana, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.tipo-jordanas');
    
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

      $tipo_jordana = TipoJordana::find( $id ) ;

      if (!empty($tipo_jordana))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $tipo_jordana->getAttributes();
        $tipo_jordana->estado = $estado;
        $tipo_jordana->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_jordana, "update estado", $attributes_old) ;
        
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

      $tipo_jordana = TipoJordana::find( $id ) ;

      if (!empty($tipo_jordana))
      {

        $tipo_jordana->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_jordana, "destroy") ;
        
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
          "success"  => false,
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

      $data = TipoJordana::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}