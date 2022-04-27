<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\TipoIdentidad; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class TipoIdentidadController
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

      $data = TipoIdentidad::get();

      return view($this->prefixView.'.tipo-identidads.list-tipo-identidads')->with(compact('data'));
    
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

      $data = TipoIdentidad::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.tipo-identidads.list-table-tipo-identidads')->with(compact('data'));
    
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
        return view($this->prefixView.'.tipo-identidads.form-create-tipo-identidad');
      }

      return view($this->prefixView.'.tipo-identidads.new-tipo-identidad');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(TipoIdentidadStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $cod_ti = $request->input('cod_ti');
      $abrv_ti = $request->input('abrv_ti');
      $descripcion = $request->input('descripcion');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $tipo_identidad = new TipoIdentidad();
        $tipo_identidad->cod_ti = $cod_ti;
        $tipo_identidad->abrv_ti = $abrv_ti;
        $tipo_identidad->descripcion = $descripcion;
        $tipo_identidad->estado = $estado;
        
        $success = $tipo_identidad->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_identidad, "created") ;
        
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
    
      return redirect()->route('admin.tipo-identidads');
    
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

      $tipo_identidad = TipoIdentidad::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.tipo-identidads.form-edit-tipo-identidad')->with(compact('tipo_identidad'));
      }

      return view($this->prefixView.'.tipo-identidads.edit-tipo-identidad')->with(compact('tipo_identidad'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function update(TipoIdentidadUpdateRequest $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id = $request->input('id');
      $cod_ti = $request->input('cod_ti');
      $abrv_ti = $request->input('abrv_ti');
      $descripcion = $request->input('descripcion');

      if (!empty($id))
      {
        $tipo_identidad = TipoIdentidad::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $tipo_identidad->getAttributes();

        $tipo_identidad->id = $id;
        $tipo_identidad->cod_ti = $cod_ti;
        $tipo_identidad->abrv_ti = $abrv_ti;
        $tipo_identidad->descripcion = $descripcion;
        
        $success = $tipo_identidad->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_identidad, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.tipo-identidads');
    
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

      $tipo_identidad = TipoIdentidad::find( $id ) ;

      if (!empty($tipo_identidad))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $tipo_identidad->getAttributes();

        $tipo_identidad->estado = $estado;
        $tipo_identidad->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_identidad, "update estado", $attributes_old) ;
        
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

      $tipo_identidad = TipoIdentidad::find( $id ) ;

      if (!empty($tipo_identidad))
      {

        $tipo_identidad->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_identidad, "destroy") ;
        
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

      $data = TipoIdentidad::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}