<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\TipoPrecio; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class TipoPrecioController
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

      $data = TipoPrecio::get();

      return view($this->prefixView.'.tipo-precios.list-tipo-precios')->with(compact('data'));
    
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

      $data = TipoPrecio::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.tipo-precios.list-table-tipo-precios')->with(compact('data'));
    
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
        return view($this->prefixView.'.tipo-precios.form-create-tipo-precio');
      }

      return view($this->prefixView.'.tipo-precios.new-tipo-precio');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(TipoPrecioStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $tipo_moneda_id = $request->input('tipo_moneda_id');
      $descripcion = $request->input('descripcion');
      $is_base = $request->input('is_base');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $tipo_precio = new TipoPrecio();
        $tipo_precio->tipo_moneda_id = $tipo_moneda_id;
        $tipo_precio->descripcion = $descripcion;
        $tipo_precio->is_base = $is_base;
        $tipo_precio->estado = $estado;
        
        $success = $tipo_precio->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_precio, "created") ;
        
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
    
      return redirect()->route('admin.tipo-precios');
    
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

      $tipo_precio = TipoPrecio::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.tipo-precios.form-edit-tipo-precio')->with(compact('tipo_precio'));
      }

      return view($this->prefixView.'.tipo-precios.edit-tipo-precio')->with(compact('tipo_precio'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function update(TipoPrecioUpdateRequest $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id = $request->input('id');
      $tipo_moneda_id = $request->input('tipo_moneda_id');
      $descripcion = $request->input('descripcion');
      $is_base = $request->input('is_base');

      if (!empty($id))
      {
        $tipo_precio = TipoPrecio::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $tipo_precio->getAttributes();

        $tipo_precio->id = $id;
        $tipo_precio->tipo_moneda_id = $tipo_moneda_id;
        $tipo_precio->descripcion = $descripcion;
        $tipo_precio->is_base = $is_base;
        
        $success = $tipo_precio->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_precio, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.tipo-precios');
    
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

      $tipo_precio = TipoPrecio::find( $id ) ;

      if (!empty($tipo_precio))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $tipo_precio->getAttributes();

        $tipo_precio->estado = $estado;
        $tipo_precio->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_precio, "update estado", $attributes_old) ;
        
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

      $tipo_precio = TipoPrecio::find( $id ) ;

      if (!empty($tipo_precio))
      {

        $tipo_precio->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_precio, "destroy") ;
        
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

      $data = TipoPrecio::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}