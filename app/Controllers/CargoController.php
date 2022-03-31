<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Cargo; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class CargoController
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

      $data = Cargo::get();

      return view($this->prefixView.'.cargos.list-cargos')->with(compact('data'));
    
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

      $data = Cargo::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.cargos.list-tablecargos')->with(compact('data'));
    
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
        return view($this->prefixView.'.cargos.form-create-cargo');
      }

      return view($this->prefixView.'.cargos.new-cargo');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(CargoStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $descripcion = $request->input('descripcion');
      $glosa = $request->input('glosa');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $cargo = new Cargo();
        $cargo->descripcion = $descripcion;
        $cargo->glosa = $glosa;
        $cargo->estado = $estado;
        
        $success = $cargo->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $cargo, "created") ;
        
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
    
      return redirect()->route('admin-cargos');
    
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

      $cargo = Cargo::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView . '.areas.form-edit-cargo')->with(compact('cargo'));
      }

      return view($this->prefixView.'.cargos.edit-cargo')->with(compact('cargo'));
    
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
      $descripcion = $request->input('descripcion');
      $glosa = $request->input('glosa');

      if (!empty($id))
      {
        $cargo = Cargo::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $cargo->getAttributes();
        $cargo->id = $id;
        $cargo->descripcion = $descripcion;
        $cargo->glosa = $glosa;
        
        $success = $cargo->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $cargo, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.cargos');
    
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

      $cargo = Cargo::find( $id ) ;

      if (!empty($cargo))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $cargo->getAttributes();
        $cargo->estado = $estado;
        $cargo->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $cargo, "update estado", $attributes_old) ;
        
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

      $data = Cargo::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}