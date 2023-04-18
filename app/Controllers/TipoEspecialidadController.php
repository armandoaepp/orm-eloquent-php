<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\TipoEspecialidad; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class TipoEspecialidadController
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

      $data = TipoEspecialidad::get();

      return view($this->prefixView.'.tipo-especialidads.list-tipo-especialidads')->with(compact('data'));
    
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

      $data = TipoEspecialidad::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.tipo-especialidads.list-table-tipo-especialidads')->with(compact('data'));
    
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
        return view($this->prefixView.'.tipo-especialidads.form-create-tipo-especialidad');
      }

      return view($this->prefixView.'.tipo-especialidads.new-tipo-especialidad');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(TipoEspecialidadStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $descripcion = $request->input('descripcion');
      $publicar = $request->input('publicar');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $tipo_especialidad = new TipoEspecialidad();
        $tipo_especialidad->descripcion = $descripcion;
        $tipo_especialidad->publicar = $publicar;
        $tipo_especialidad->estado = $estado;
        
        $success = $tipo_especialidad->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_especialidad, "created") ;
        
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
    
      return redirect()->route('admin.tipo-especialidads');
    
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

      $tipo_especialidad = TipoEspecialidad::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.tipo-especialidads.form-edit-tipo-especialidad')->with(compact('tipo_especialidad'));
      }

      return view($this->prefixView.'.tipo-especialidads.edit-tipo-especialidad')->with(compact('tipo_especialidad'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function update(TipoEspecialidadUpdateRequest $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id = $request->input('id');
      $descripcion = $request->input('descripcion');
      $publicar = $request->input('publicar');

      if (!empty($id))
      {
        $tipo_especialidad = TipoEspecialidad::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $tipo_especialidad->getAttributes();

        $tipo_especialidad->id = $id;
        $tipo_especialidad->descripcion = $descripcion;
        $tipo_especialidad->publicar = $publicar;
        
        $success = $tipo_especialidad->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_especialidad, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.tipo-especialidads');
    
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

      $tipo_especialidad = TipoEspecialidad::find( $id ) ;

      if (!empty($tipo_especialidad))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $tipo_especialidad->getAttributes();

        $tipo_especialidad->estado = $estado;
        $tipo_especialidad->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_especialidad, "update estado", $attributes_old) ;
        
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

      $tipo_especialidad = TipoEspecialidad::find( $id ) ;

      if (!empty($tipo_especialidad))
      {

        $tipo_especialidad->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_especialidad, "destroy") ;
        
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

        $tipo_especialidad = TipoEspecialidad::find($id);
        if (!empty($tipo_especialidad))
        {

          # Values OLD FOR BITACORA
          $attributes_old = $tipo_especialidad->getAttributes(); 

          $tipo_especialidad->publicar = $publicar;
          $tipo_especialidad->save();

          # TABLE BITACORA
          $this->savedBitacoraTrait( $tipo_especialidad, "update publicar", $attributes_old) ;

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

      $data = TipoEspecialidad::where("publicar", $publicar)->get();

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

      $data = TipoEspecialidad::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}