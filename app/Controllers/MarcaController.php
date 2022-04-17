<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Marca; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class MarcaController
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

      $data = Marca::get();

      return view($this->prefixView.'.marcas.list-marcas')->with(compact('data'));
    
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

      $data = Marca::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.marcas.list-table-marcas')->with(compact('data'));
    
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
        return view($this->prefixView.'.marcas.form-create-marca');
      }

      return view($this->prefixView.'.marcas.new-marca');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(MarcaStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $codigo = $request->input('codigo');
      $descripcion = $request->input('descripcion');
      $glosa = $request->input('glosa');
      $imagen = $request->file('imagen');
      $publicar = $request->input('publicar');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        ##################################################################################
        $path_relative = "images/marcas/" ;
        $name_file     = "imagen";
        $image_url     = UploadFiles::uploadFile($request, $name_file , $path_relative);
        $imagen    = $image_url ;
        ##################################################################################

        $marca = new Marca();
        $marca->codigo = $codigo;
        $marca->descripcion = $descripcion;
        $marca->glosa = $glosa;
        $marca->publicar = $publicar;
        $marca->estado = $estado;
        
        $success = $marca->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $marca, "created") ;
        
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
    
      return redirect()->route('admin.marcas');
    
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

      $marca = Marca::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.marcas.form-edit-marca')->with(compact('marca'));
      }

      return view($this->prefixView.'.marcas.edit-marca')->with(compact('marca'));
    
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
      $codigo = $request->input('codigo');
      $descripcion = $request->input('descripcion');
      $glosa = $request->input('glosa');
      $imagen = $request->file('imagen');
      $img_bd     = $request->input('img_bd');
      $publicar = $request->input('publicar');

      if (!empty($id))
      {
        ##################################################################################
        $path_relative = "images/marcas/" ;
        $name_file     = "imagen";
        $image_url     = UploadFiles::uploadFile($request, $name_file , $path_relative);
        
        if(empty($image_url))
        {
          $image_url = $img_bd ;
        }
        
        $imagen    = $image_url ;
        ##################################################################################

        $marca = Marca::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $marca->getAttributes();
        $marca->id = $id;
        $marca->codigo = $codigo;
        $marca->descripcion = $descripcion;
        $marca->glosa = $glosa;
        $marca->imagen = $imagen;
        $marca->publicar = $publicar;
        
        $success = $marca->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $marca, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.marcas');
    
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

      $marca = Marca::find( $id ) ;

      if (!empty($marca))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $marca->getAttributes();
        $marca->estado = $estado;
        $marca->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $marca, "update estado", $attributes_old) ;
        
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

      $marca = Marca::find( $id ) ;

      if (!empty($marca))
      {

        $marca->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $marca, "destroy") ;
        
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

        $marca = Marca::find($id);
        if (!empty($marca))
        {

          # Values OLD FOR BITACORA
          $attributes_old = $marca->getAttributes(); 

          $marca->publicar = $publicar;
          $marca->save();

          # TABLE BITACORA
          $this->savedBitacoraTrait( $marca, "update publicar", $attributes_old) ;

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

      $data = Marca::where("publicar", $publicar)->get();

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

      $data = Marca::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}