<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\PersonaDocIdentidad; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PersonaDocIdentidadController
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

      $data = PersonaDocIdentidad::get();

      return view($this->prefixView.'.persona-doc-identidads.list-persona-doc-identidads')->with(compact('data'));
    
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

      $data = PersonaDocIdentidad::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.persona-doc-identidads.list-table-persona-doc-identidads')->with(compact('data'));
    
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
        return view($this->prefixView.'.persona-doc-identidads.form-create-persona-doc-identidad');
      }

      return view($this->prefixView.'.persona-doc-identidads.new-persona-doc-identidad');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(PersonaDocIdentidadStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $persona_id = $request->input('persona_id');
      $tipo_identidad_id = $request->input('tipo_identidad_id');
      $num_doc = $request->input('num_doc');
      $is_principal = $request->input('is_principal');
      $fecha_emision = $request->input('fecha_emision');
      $fecha_caducidad = $request->input('fecha_caducidad');
      $imagen = $request->file('imagen');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        ##################################################################################
        $path_relative = "images/persona_doc_identidads/" ;
        $name_file     = "imagen";
        $image_url     = UploadFiles::uploadFile($request, $name_file , $path_relative);
        $imagen    = $image_url ;
        ##################################################################################

        $persona_doc_identidad = new PersonaDocIdentidad();
        $persona_doc_identidad->persona_id = $persona_id;
        $persona_doc_identidad->tipo_identidad_id = $tipo_identidad_id;
        $persona_doc_identidad->num_doc = $num_doc;
        $persona_doc_identidad->is_principal = $is_principal;
        $persona_doc_identidad->fecha_emision = $fecha_emision;
        $persona_doc_identidad->fecha_caducidad = $fecha_caducidad;
        $persona_doc_identidad->estado = $estado;
        
        $success = $persona_doc_identidad->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_doc_identidad, "created") ;
        
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
    
      return redirect()->route('admin.persona-doc-identidads');
    
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

      $persona_doc_identidad = PersonaDocIdentidad::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.persona-doc-identidads.form-edit-persona-doc-identidad')->with(compact('persona_doc_identidad'));
      }

      return view($this->prefixView.'.persona-doc-identidads.edit-persona-doc-identidad')->with(compact('persona_doc_identidad'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function update(PersonaDocIdentidadUpdateRequest $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id = $request->input('id');
      $persona_id = $request->input('persona_id');
      $tipo_identidad_id = $request->input('tipo_identidad_id');
      $num_doc = $request->input('num_doc');
      $is_principal = $request->input('is_principal');
      $fecha_emision = $request->input('fecha_emision');
      $fecha_caducidad = $request->input('fecha_caducidad');
      $imagen = $request->file('imagen');
      $img_bd     = $request->input('img_bd');

      if (!empty($id))
      {
        ##################################################################################
        $path_relative = "images/persona_doc_identidads/" ;
        $name_file     = "imagen";
        $image_url     = UploadFiles::uploadFile($request, $name_file , $path_relative);
        
        if(empty($image_url))
        {
          $image_url = $img_bd ;
        }
        
        $imagen    = $image_url ;
        ##################################################################################

        $persona_doc_identidad = PersonaDocIdentidad::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $persona_doc_identidad->getAttributes();

        $persona_doc_identidad->id = $id;
        $persona_doc_identidad->persona_id = $persona_id;
        $persona_doc_identidad->tipo_identidad_id = $tipo_identidad_id;
        $persona_doc_identidad->num_doc = $num_doc;
        $persona_doc_identidad->is_principal = $is_principal;
        $persona_doc_identidad->fecha_emision = $fecha_emision;
        $persona_doc_identidad->fecha_caducidad = $fecha_caducidad;
        $persona_doc_identidad->imagen = $imagen;
        
        $success = $persona_doc_identidad->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_doc_identidad, "update", $attributes_old) ;
        
        # remove imagen
        if($imagen != $img_bd && $success )
        {
          if (file_exists($img_bd))
            unlink($img_bd) ;
        }
        
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

      return redirect()->route('admin.persona-doc-identidads');
    
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

      $persona_doc_identidad = PersonaDocIdentidad::find( $id ) ;

      if (!empty($persona_doc_identidad))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $persona_doc_identidad->getAttributes();

        $persona_doc_identidad->estado = $estado;
        $persona_doc_identidad->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_doc_identidad, "update estado", $attributes_old) ;
        
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

      $persona_doc_identidad = PersonaDocIdentidad::find( $id ) ;

      if (!empty($persona_doc_identidad))
      {

        $persona_doc_identidad->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_doc_identidad, "destroy") ;
        
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

      $data = PersonaDocIdentidad::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}