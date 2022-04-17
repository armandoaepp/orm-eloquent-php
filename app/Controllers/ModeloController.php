<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Modelo; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class ModeloController
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

      $data = Modelo::get();

      return view($this->prefixView.'.modelos.list-modelos')->with(compact('data'));
    
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

      $data = Modelo::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.modelos.list-table-modelos')->with(compact('data'));
    
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
        return view($this->prefixView.'.modelos.form-create-modelo');
      }

      return view($this->prefixView.'.modelos.new-modelo');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(ModeloStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $marca_id = $request->input('marca_id');
      $codigo = $request->input('codigo');
      $descripcion = $request->input('descripcion');
      $glosa = $request->input('glosa');
      $publicar = $request->input('publicar');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $modelo = new Modelo();
        $modelo->marca_id = $marca_id;
        $modelo->codigo = $codigo;
        $modelo->descripcion = $descripcion;
        $modelo->glosa = $glosa;
        $modelo->publicar = $publicar;
        $modelo->estado = $estado;
        
        $success = $modelo->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $modelo, "created") ;
        
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
    
      return redirect()->route('admin.modelos');
    
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

      $modelo = Modelo::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.modelos.form-edit-modelo')->with(compact('modelo'));
      }

      return view($this->prefixView.'.modelos.edit-modelo')->with(compact('modelo'));
    
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
      $marca_id = $request->input('marca_id');
      $codigo = $request->input('codigo');
      $descripcion = $request->input('descripcion');
      $glosa = $request->input('glosa');
      $publicar = $request->input('publicar');

      if (!empty($id))
      {
        $modelo = Modelo::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $modelo->getAttributes();

        $modelo->id = $id;
        $modelo->marca_id = $marca_id;
        $modelo->codigo = $codigo;
        $modelo->descripcion = $descripcion;
        $modelo->glosa = $glosa;
        $modelo->publicar = $publicar;
        
        $success = $modelo->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $modelo, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.modelos');
    
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

      $modelo = Modelo::find( $id ) ;

      if (!empty($modelo))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $modelo->getAttributes();

        $modelo->estado = $estado;
        $modelo->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $modelo, "update estado", $attributes_old) ;
        
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

      $modelo = Modelo::find( $id ) ;

      if (!empty($modelo))
      {

        $modelo->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $modelo, "destroy") ;
        
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

  public function updatePublish(Request $request )
  {
    try
    {
      $success = false;
      $message = "";

      $validator = \Validator::make($request->all(), [
        'id'       => 'required|numeric',
        'publicar' => 'required|max:2',
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

      $id = $request->input("id");
      $publicar = $request->input("publicar");

      if (!empty($id))
      {

        if ($publicar == "S") {
          $message = "Registro PUBLICADO Correctamente";
        } else {
          $message = "Registro OCULTADO al Público Correctamente";
        }

        $modelo = Modelo::find($id);
        if (!empty($modelo))
        {

          # Values OLD FOR BITACORA
          $attributes_old = $modelo->getAttributes(); 

          $modelo->publicar = $publicar;
          $modelo->save();

          # TABLE BITACORA
          $this->savedBitacoraTrait( $modelo, "update publicar", $attributes_old) ;

          $success = true;
          $code = 200;

        }
        else
        {
          $message = "¡El registro no exite o el identificador es incorrecto!";
          $code = 400;
        }
        
      }
      else
      {
        $message = "¡El identificador es incorrecto!";
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

  public function getPublished(  $params = array()  )
  {
    try
    {
      extract($params) ;

      $data = Modelo::where("publicar", $publicar)->get();

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function find( $id )
  {
    try
    {

      $data = Modelo::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}
