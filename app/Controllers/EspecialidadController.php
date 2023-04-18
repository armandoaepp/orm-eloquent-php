<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Especialidad; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class EspecialidadController
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

      $data = Especialidad::get();

      return view($this->prefixView.'.especialidads.list-especialidads')->with(compact('data'));
    
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

      $data = Especialidad::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.especialidads.list-table-especialidads')->with(compact('data'));
    
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
        return view($this->prefixView.'.especialidads.form-create-especialidad');
      }

      return view($this->prefixView.'.especialidads.new-especialidad');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(EspecialidadStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $tipo_especialidad_id = $request->input('tipo_especialidad_id');
      $cod_esp = $request->input('cod_esp');
      $descripcion = $request->input('descripcion');
      $observacion = $request->input('observacion');
      $publicar = $request->input('publicar');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $especialidad = new Especialidad();
        $especialidad->tipo_especialidad_id = $tipo_especialidad_id;
        $especialidad->cod_esp = $cod_esp;
        $especialidad->descripcion = $descripcion;
        $especialidad->observacion = $observacion;
        $especialidad->publicar = $publicar;
        $especialidad->estado = $estado;
        
        $success = $especialidad->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $especialidad, "created") ;
        
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
    
      return redirect()->route('admin.especialidads');
    
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

      $especialidad = Especialidad::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.especialidads.form-edit-especialidad')->with(compact('especialidad'));
      }

      return view($this->prefixView.'.especialidads.edit-especialidad')->with(compact('especialidad'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function update(EspecialidadUpdateRequest $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id = $request->input('id');
      $tipo_especialidad_id = $request->input('tipo_especialidad_id');
      $cod_esp = $request->input('cod_esp');
      $descripcion = $request->input('descripcion');
      $observacion = $request->input('observacion');
      $publicar = $request->input('publicar');

      if (!empty($id))
      {
        $especialidad = Especialidad::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $especialidad->getAttributes();

        $especialidad->id = $id;
        $especialidad->tipo_especialidad_id = $tipo_especialidad_id;
        $especialidad->cod_esp = $cod_esp;
        $especialidad->descripcion = $descripcion;
        $especialidad->observacion = $observacion;
        $especialidad->publicar = $publicar;
        
        $success = $especialidad->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $especialidad, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.especialidads');
    
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

      $especialidad = Especialidad::find( $id ) ;

      if (!empty($especialidad))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $especialidad->getAttributes();

        $especialidad->estado = $estado;
        $especialidad->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $especialidad, "update estado", $attributes_old) ;
        
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

      $especialidad = Especialidad::find( $id ) ;

      if (!empty($especialidad))
      {

        $especialidad->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $especialidad, "destroy") ;
        
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

        $especialidad = Especialidad::find($id);
        if (!empty($especialidad))
        {

          # Values OLD FOR BITACORA
          $attributes_old = $especialidad->getAttributes(); 

          $especialidad->publicar = $publicar;
          $especialidad->save();

          # TABLE BITACORA
          $this->savedBitacoraTrait( $especialidad, "update publicar", $attributes_old) ;

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

      $data = Especialidad::where("publicar", $publicar)->get();

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

      $data = Especialidad::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}