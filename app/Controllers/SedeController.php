<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Sede; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class SedeController
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

      $data = Sede::get();

      return view($this->prefixView.'.sedes.list-sedes')->with(compact('data'));
    
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

      $data = Sede::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.sedes.list-table-sedes')->with(compact('data'));
    
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
        return view($this->prefixView.'.sedes.form-create-sede');
      }

      return view($this->prefixView.'.sedes.new-sede');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(SedeStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $corporacion_id = $request->input('corporacion_id');
      $nombre = $request->input('nombre');
      $ubigeo_id = $request->input('ubigeo_id');
      $direccion = $request->input('direccion');
      $principal = $request->input('principal');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $sede = new Sede();
        $sede->corporacion_id = $corporacion_id;
        $sede->nombre = $nombre;
        $sede->ubigeo_id = $ubigeo_id;
        $sede->direccion = $direccion;
        $sede->principal = $principal;
        $sede->estado = $estado;
        
        $success = $sede->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $sede, "created") ;
        
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
    
      return redirect()->route('admin.sedes');
    
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

  public function edit( $sede_id, Request $request)
  {
    try
    {

      $sede = Sede::find( $sede_id );

      if ($request->ajax()) {
        return view($this->prefixView .'.sedes.form-edit-sede')->with(compact('sede'));
      }

      return view($this->prefixView.'.sedes.edit-sede')->with(compact('sede'));
    
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

      $sede_id = $request->input('sede_id');
      $corporacion_id = $request->input('corporacion_id');
      $nombre = $request->input('nombre');
      $ubigeo_id = $request->input('ubigeo_id');
      $direccion = $request->input('direccion');
      $principal = $request->input('principal');

      if (!empty($sede_id))
      {
        $sede = Sede::find($sede_id);

        # For Bitacora Atributos Old;
        $attributes_old = $sede->getAttributes();
        $sede->sede_id = $sede_id;
        $sede->corporacion_id = $corporacion_id;
        $sede->nombre = $nombre;
        $sede->ubigeo_id = $ubigeo_id;
        $sede->direccion = $direccion;
        $sede->principal = $principal;
        
        $success = $sede->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $sede, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.sedes');
    
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

      $sede = Sede::find( $sede_id ) ;

      if (!empty($sede))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $sede->getAttributes();
        $sede->estado = $estado;
        $sede->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $sede, "update estado", $attributes_old) ;
        
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

      $sede = Sede::find( $sede_id ) ;

      if (!empty($sede))
      {

        $sede->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $sede, "destroy") ;
        
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

  public function find( $sede_id )
  {
    try
    {

      $data = Sede::find($sede_id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}