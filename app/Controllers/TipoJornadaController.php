<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\TipoJornada; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class TipoJornadaController
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

      $data = TipoJornada::get();

      return view($this->prefixView.'.tipo-jornadas.list-tipo-jornadas')->with(compact('data'));
    
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

      $data = TipoJornada::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.tipo-jornadas.list-table-tipo-jornadas')->with(compact('data'));
    
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
        return view($this->prefixView.'.tipo-jornadas.form-create-tipo-jornada');
      }

      return view($this->prefixView.'.tipo-jornadas.new-tipo-jornada');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(TipoJornadaStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $cod_tj = $request->input('cod_tj');
      $descripcion = $request->input('descripcion');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $tipo_jornada = new TipoJornada();
        $tipo_jornada->cod_tj = $cod_tj;
        $tipo_jornada->descripcion = $descripcion;
        $tipo_jornada->estado = $estado;
        
        $success = $tipo_jornada->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_jornada, "created") ;
        
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
    
      return redirect()->route('admin.tipo-jornadas');
    
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

      $tipo_jornada = TipoJornada::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.tipo-jornadas.form-edit-tipo-jornada')->with(compact('tipo_jornada'));
      }

      return view($this->prefixView.'.tipo-jornadas.edit-tipo-jornada')->with(compact('tipo_jornada'));
    
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
        $tipo_jornada = TipoJornada::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $tipo_jornada->getAttributes();
        $tipo_jornada->id = $id;
        $tipo_jornada->cod_tj = $cod_tj;
        $tipo_jornada->descripcion = $descripcion;
        
        $success = $tipo_jornada->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_jornada, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.tipo-jornadas');
    
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

      $tipo_jornada = TipoJornada::find( $id ) ;

      if (!empty($tipo_jornada))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $tipo_jornada->getAttributes();
        $tipo_jornada->estado = $estado;
        $tipo_jornada->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_jornada, "update estado", $attributes_old) ;
        
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

      $tipo_jornada = TipoJornada::find( $id ) ;

      if (!empty($tipo_jornada))
      {

        $tipo_jornada->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_jornada, "destroy") ;
        
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

      $data = TipoJornada::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}