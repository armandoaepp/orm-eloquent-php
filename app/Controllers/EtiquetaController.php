<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Etiqueta; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class EtiquetaController
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

      $data = Etiqueta::get();

      return view($this->prefixView.'.etiquetas.list-etiquetas')->with(compact('data'));
    
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

      $data = Etiqueta::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.etiquetas.list-table-etiquetas')->with(compact('data'));
    
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
        return view($this->prefixView.'.etiquetas.form-create-etiqueta');
      }

      return view($this->prefixView.'.etiquetas.new-etiqueta');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(EtiquetaStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $desc_eti = $request->input('desc_eti');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $etiqueta = new Etiqueta();
        $etiqueta->desc_eti = $desc_eti;
        $etiqueta->estado = $estado;
        
        $success = $etiqueta->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $etiqueta, "created") ;
        
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
    
      return redirect()->route('admin.etiquetas');
    
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

      $etiqueta = Etiqueta::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.etiquetas.form-edit-etiqueta')->with(compact('etiqueta'));
      }

      return view($this->prefixView.'.etiquetas.edit-etiqueta')->with(compact('etiqueta'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function update(EtiquetaUpdateRequest $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id = $request->input('id');
      $desc_eti = $request->input('desc_eti');

      if (!empty($id))
      {
        $etiqueta = Etiqueta::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $etiqueta->getAttributes();

        $etiqueta->id = $id;
        $etiqueta->desc_eti = $desc_eti;
        
        $success = $etiqueta->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $etiqueta, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.etiquetas');
    
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

      $etiqueta = Etiqueta::find( $id ) ;

      if (!empty($etiqueta))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $etiqueta->getAttributes();

        $etiqueta->estado = $estado;
        $etiqueta->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $etiqueta, "update estado", $attributes_old) ;
        
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

      $etiqueta = Etiqueta::find( $id ) ;

      if (!empty($etiqueta))
      {

        $etiqueta->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $etiqueta, "destroy") ;
        
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

      $data = Etiqueta::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}