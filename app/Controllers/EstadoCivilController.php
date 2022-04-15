<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\EstadoCivil; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class EstadoCivilController
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

      $data = EstadoCivil::get();

      return view($this->prefixView.'.estado-civils.list-estado-civils')->with(compact('data'));
    
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

      $data = EstadoCivil::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.estado-civils.list-table-estado-civils')->with(compact('data'));
    
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
        return view($this->prefixView.'.estado-civils.form-create-estado-civil');
      }

      return view($this->prefixView.'.estado-civils.new-estado-civil');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(EstadoCivilStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $cod_ec = $request->input('cod_ec');
      $descripcion = $request->input('descripcion');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $estado_civil = new EstadoCivil();
        $estado_civil->cod_ec = $cod_ec;
        $estado_civil->descripcion = $descripcion;
        $estado_civil->estado = $estado;
        
        $success = $estado_civil->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $estado_civil, "created") ;
        
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
    
      return redirect()->route('admin.estado-civils');
    
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

      $estado_civil = EstadoCivil::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.estado-civils.form-edit-estado-civil')->with(compact('estado_civil'));
      }

      return view($this->prefixView.'.estado-civils.edit-estado-civil')->with(compact('estado_civil'));
    
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
        $estado_civil = EstadoCivil::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $estado_civil->getAttributes();
        $estado_civil->id = $id;
        $estado_civil->cod_ec = $cod_ec;
        $estado_civil->descripcion = $descripcion;
        
        $success = $estado_civil->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $estado_civil, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.estado-civils');
    
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

      $estado_civil = EstadoCivil::find( $id ) ;

      if (!empty($estado_civil))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $estado_civil->getAttributes();
        $estado_civil->estado = $estado;
        $estado_civil->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $estado_civil, "update estado", $attributes_old) ;
        
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

      $estado_civil = EstadoCivil::find( $id ) ;

      if (!empty($estado_civil))
      {

        $estado_civil->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $estado_civil, "destroy") ;
        
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

      $data = EstadoCivil::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}