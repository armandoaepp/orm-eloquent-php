<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\PersonaImagen; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PersonaImagenController
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

      $data = PersonaImagen::get();

      return view($this->prefixView.'.persona-imagens.list-persona-imagens')->with(compact('data'));
    
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

      $data = PersonaImagen::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.persona-imagens.list-table-persona-imagens')->with(compact('data'));
    
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
        return view($this->prefixView.'.persona-imagens.form-create-persona-imagen');
      }

      return view($this->prefixView.'.persona-imagens.new-persona-imagen');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(PersonaImagenStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $persona_id = $request->input('persona_id');
      $url = $request->input('url');
      $tipo = $request->input('tipo');
      $is_principal = $request->input('is_principal');
      $jerarquia = $request->input('jerarquia');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $persona_imagen = new PersonaImagen();
        $persona_imagen->persona_id = $persona_id;
        $persona_imagen->url = $url;
        $persona_imagen->tipo = $tipo;
        $persona_imagen->is_principal = $is_principal;
        $persona_imagen->jerarquia = $jerarquia;
        $persona_imagen->estado = $estado;
        
        $success = $persona_imagen->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_imagen, "created") ;
        
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
    
      return redirect()->route('admin.persona-imagens');
    
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

      $persona_imagen = PersonaImagen::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.persona-imagens.form-edit-persona-imagen')->with(compact('persona_imagen'));
      }

      return view($this->prefixView.'.persona-imagens.edit-persona-imagen')->with(compact('persona_imagen'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function update(PersonaImagenUpdateRequest $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id = $request->input('id');
      $persona_id = $request->input('persona_id');
      $url = $request->input('url');
      $tipo = $request->input('tipo');
      $is_principal = $request->input('is_principal');
      $jerarquia = $request->input('jerarquia');

      if (!empty($id))
      {
        $persona_imagen = PersonaImagen::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $persona_imagen->getAttributes();

        $persona_imagen->id = $id;
        $persona_imagen->persona_id = $persona_id;
        $persona_imagen->url = $url;
        $persona_imagen->tipo = $tipo;
        $persona_imagen->is_principal = $is_principal;
        $persona_imagen->jerarquia = $jerarquia;
        
        $success = $persona_imagen->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_imagen, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.persona-imagens');
    
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

      $persona_imagen = PersonaImagen::find( $id ) ;

      if (!empty($persona_imagen))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $persona_imagen->getAttributes();

        $persona_imagen->estado = $estado;
        $persona_imagen->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_imagen, "update estado", $attributes_old) ;
        
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

      $persona_imagen = PersonaImagen::find( $id ) ;

      if (!empty($persona_imagen))
      {

        $persona_imagen->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $persona_imagen, "destroy") ;
        
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

      $data = PersonaImagen::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}