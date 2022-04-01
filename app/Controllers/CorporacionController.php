<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Corporacion; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class CorporacionController
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

      $data = Corporacion::get();

      return view($this->prefixView.'.corporacions.list-corporacions')->with(compact('data'));
    
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

      $data = Corporacion::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.corporacions.list-table-corporacions')->with(compact('data'));
    
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
        return view($this->prefixView.'.corporacions.form-create-corporacion');
      }

      return view($this->prefixView.'.corporacions.new-corporacion');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(CorporacionStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $ruc = $request->input('ruc');
      $razon_social = $request->input('razon_social');
      $nombre_com = $request->input('nombre_com');
      $ubigeo_id = $request->input('ubigeo_id');
      $direccion = $request->input('direccion');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $corporacion = new Corporacion();
        $corporacion->ruc = $ruc;
        $corporacion->razon_social = $razon_social;
        $corporacion->nombre_com = $nombre_com;
        $corporacion->ubigeo_id = $ubigeo_id;
        $corporacion->direccion = $direccion;
        $corporacion->estado = $estado;
        
        $success = $corporacion->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $corporacion, "created") ;
        
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
    
      return redirect()->route('admin-corporacions');
    
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

      $corporacion = Corporacion::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'corporacions.form-edit-corporacion')->with(compact('corporacion'));
      }

      return view($this->prefixView.'.corporacions.edit-corporacion')->with(compact('corporacion'));
    
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
      $ruc = $request->input('ruc');
      $razon_social = $request->input('razon_social');
      $nombre_com = $request->input('nombre_com');
      $ubigeo_id = $request->input('ubigeo_id');
      $direccion = $request->input('direccion');

      if (!empty($id))
      {
        $corporacion = Corporacion::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $corporacion->getAttributes();
        $corporacion->id = $id;
        $corporacion->ruc = $ruc;
        $corporacion->razon_social = $razon_social;
        $corporacion->nombre_com = $nombre_com;
        $corporacion->ubigeo_id = $ubigeo_id;
        $corporacion->direccion = $direccion;
        
        $success = $corporacion->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $corporacion, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.corporacions');
    
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

      $corporacion = Corporacion::find( $id ) ;

      if (!empty($corporacion))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $corporacion->getAttributes();
        $corporacion->estado = $estado;
        $corporacion->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $corporacion, "update estado", $attributes_old) ;
        
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

  public function find( $id )
  {
    try
    {

      $data = Corporacion::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}