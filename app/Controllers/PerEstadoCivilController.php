<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\PerEstadoCivil; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PerEstadoCivilController
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

      $data = PerEstadoCivil::get();

      return view($this->prefixView.'.per-estado-civils.list-per-estado-civils')->with(compact('data'));
    
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

      $data = PerEstadoCivil::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.per-estado-civils.list-table-per-estado-civils')->with(compact('data'));
    
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
        return view($this->prefixView.'.per-estado-civils.form-create-per-estado-civil');
      }

      return view($this->prefixView.'.per-estado-civils.new-per-estado-civil');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(PerEstadoCivilStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $cod_ec = $request->input('cod_ec');
      $descripcion = $request->input('descripcion');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $per_estado_civil = new PerEstadoCivil();
        $per_estado_civil->cod_ec = $cod_ec;
        $per_estado_civil->descripcion = $descripcion;
        $per_estado_civil->estado = $estado;
        
        $success = $per_estado_civil->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $per_estado_civil, "created") ;
        
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
    
      return redirect()->route('admin.per-estado-civils');
    
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

      $per_estado_civil = PerEstadoCivil::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.per-estado-civils.form-edit-per-estado-civil')->with(compact('per_estado_civil'));
      }

      return view($this->prefixView.'.per-estado-civils.edit-per-estado-civil')->with(compact('per_estado_civil'));
    
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
      $cod_ec = $request->input('cod_ec');
      $descripcion = $request->input('descripcion');

      if (!empty($id))
      {
        $per_estado_civil = PerEstadoCivil::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $per_estado_civil->getAttributes();
        $per_estado_civil->id = $id;
        $per_estado_civil->cod_ec = $cod_ec;
        $per_estado_civil->descripcion = $descripcion;
        
        $success = $per_estado_civil->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $per_estado_civil, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.per-estado-civils');
    
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

      $per_estado_civil = PerEstadoCivil::find( $id ) ;

      if (!empty($per_estado_civil))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $per_estado_civil->getAttributes();
        $per_estado_civil->estado = $estado;
        $per_estado_civil->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $per_estado_civil, "update estado", $attributes_old) ;
        
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

      $per_estado_civil = PerEstadoCivil::find( $id ) ;

      if (!empty($per_estado_civil))
      {

        $per_estado_civil->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $per_estado_civil, "destroy") ;
        
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

      $data = PerEstadoCivil::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}