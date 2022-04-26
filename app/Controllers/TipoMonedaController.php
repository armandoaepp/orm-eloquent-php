<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\TipoMoneda; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class TipoMonedaController
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

      $data = TipoMoneda::get();

      return view($this->prefixView.'.tipo-monedas.list-tipo-monedas')->with(compact('data'));
    
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

      $data = TipoMoneda::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.tipo-monedas.list-table-tipo-monedas')->with(compact('data'));
    
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
        return view($this->prefixView.'.tipo-monedas.form-create-tipo-moneda');
      }

      return view($this->prefixView.'.tipo-monedas.new-tipo-moneda');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(TipoMonedaStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $simbolo = $request->input('simbolo');
      $abreviatura = $request->input('abreviatura');
      $descripcion = $request->input('descripcion');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $tipo_moneda = new TipoMoneda();
        $tipo_moneda->simbolo = $simbolo;
        $tipo_moneda->abreviatura = $abreviatura;
        $tipo_moneda->descripcion = $descripcion;
        $tipo_moneda->estado = $estado;
        
        $success = $tipo_moneda->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_moneda, "created") ;
        
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
    
      return redirect()->route('admin.tipo-monedas');
    
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

      $tipo_moneda = TipoMoneda::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.tipo-monedas.form-edit-tipo-moneda')->with(compact('tipo_moneda'));
      }

      return view($this->prefixView.'.tipo-monedas.edit-tipo-moneda')->with(compact('tipo_moneda'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function update(TipoMonedaUpdateRequest $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id = $request->input('id');
      $simbolo = $request->input('simbolo');
      $abreviatura = $request->input('abreviatura');
      $descripcion = $request->input('descripcion');

      if (!empty($id))
      {
        $tipo_moneda = TipoMoneda::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $tipo_moneda->getAttributes();

        $tipo_moneda->id = $id;
        $tipo_moneda->simbolo = $simbolo;
        $tipo_moneda->abreviatura = $abreviatura;
        $tipo_moneda->descripcion = $descripcion;
        
        $success = $tipo_moneda->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_moneda, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.tipo-monedas');
    
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

      $tipo_moneda = TipoMoneda::find( $id ) ;

      if (!empty($tipo_moneda))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $tipo_moneda->getAttributes();

        $tipo_moneda->estado = $estado;
        $tipo_moneda->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_moneda, "update estado", $attributes_old) ;
        
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

      $tipo_moneda = TipoMoneda::find( $id ) ;

      if (!empty($tipo_moneda))
      {

        $tipo_moneda->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_moneda, "destroy") ;
        
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

      $data = TipoMoneda::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}