<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Proveedor; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class ProveedorController
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

      $data = Proveedor::get();

      return view($this->prefixView.'.proveedors.list-proveedors')->with(compact('data'));
    
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

      $data = Proveedor::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.proveedors.list-table-proveedors')->with(compact('data'));
    
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
        return view($this->prefixView.'.proveedors.form-create-proveedor');
      }

      return view($this->prefixView.'.proveedors.new-proveedor');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(ProveedorStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $ruc = $request->input('ruc');
      $razon_social = $request->input('razon_social');
      $nombre_comercial = $request->input('nombre_comercial');
      $condicion_su = $request->input('condicion_su');
      $estado_su = $request->input('estado_su');
      $domicilio_fiscal = $request->input('domicilio_fiscal');
      $ubigeo_su = $request->input('ubigeo_su');
      $glosa = $request->input('glosa');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $proveedor = new Proveedor();
        $proveedor->ruc = $ruc;
        $proveedor->razon_social = $razon_social;
        $proveedor->nombre_comercial = $nombre_comercial;
        $proveedor->condicion_su = $condicion_su;
        $proveedor->estado_su = $estado_su;
        $proveedor->domicilio_fiscal = $domicilio_fiscal;
        $proveedor->ubigeo_su = $ubigeo_su;
        $proveedor->glosa = $glosa;
        $proveedor->estado = $estado;
        
        $success = $proveedor->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $proveedor, "created") ;
        
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
    
      return redirect()->route('admin.proveedors');
    
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

      $proveedor = Proveedor::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.proveedors.form-edit-proveedor')->with(compact('proveedor'));
      }

      return view($this->prefixView.'.proveedors.edit-proveedor')->with(compact('proveedor'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function update(ProveedorUpdateRequest $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id = $request->input('id');
      $ruc = $request->input('ruc');
      $razon_social = $request->input('razon_social');
      $nombre_comercial = $request->input('nombre_comercial');
      $condicion_su = $request->input('condicion_su');
      $estado_su = $request->input('estado_su');
      $domicilio_fiscal = $request->input('domicilio_fiscal');
      $ubigeo_su = $request->input('ubigeo_su');
      $glosa = $request->input('glosa');

      if (!empty($id))
      {
        $proveedor = Proveedor::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $proveedor->getAttributes();

        $proveedor->id = $id;
        $proveedor->ruc = $ruc;
        $proveedor->razon_social = $razon_social;
        $proveedor->nombre_comercial = $nombre_comercial;
        $proveedor->condicion_su = $condicion_su;
        $proveedor->estado_su = $estado_su;
        $proveedor->domicilio_fiscal = $domicilio_fiscal;
        $proveedor->ubigeo_su = $ubigeo_su;
        $proveedor->glosa = $glosa;
        
        $success = $proveedor->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $proveedor, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.proveedors');
    
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

      $proveedor = Proveedor::find( $id ) ;

      if (!empty($proveedor))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $proveedor->getAttributes();

        $proveedor->estado = $estado;
        $proveedor->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $proveedor, "update estado", $attributes_old) ;
        
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

      $proveedor = Proveedor::find( $id ) ;

      if (!empty($proveedor))
      {

        $proveedor->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $proveedor, "destroy") ;
        
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

      $data = Proveedor::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}