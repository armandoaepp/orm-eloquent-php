<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Categoria; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class CategoriaController
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

      $data = Categoria::get();

      return view($this->prefixView.'.categorias.list-categorias')->with(compact('data'));
    
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

      $data = Categoria::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.categorias.list-table-categorias')->with(compact('data'));
    
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
        return view($this->prefixView.'.categorias.form-create-categoria');
      }

      return view($this->prefixView.'.categorias.new-categoria');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(CategoriaStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $familia_id = $request->input('familia_id');
      $cod_cat = $request->input('cod_cat');
      $descripcion = $request->input('descripcion');
      $url = $request->input('url');
      $glosa = $request->input('glosa');
      $imagen = $request->file('imagen');
      $publicar = $request->input('publicar');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        ##################################################################################
        $path_relative = "images/categorias/" ;
        $name_file     = "imagen";
        $image_url     = UploadFiles::uploadFile($request, $name_file , $path_relative);
        $imagen    = $image_url ;
        ##################################################################################

        $categoria = new Categoria();
        $categoria->familia_id = $familia_id;
        $categoria->cod_cat = $cod_cat;
        $categoria->descripcion = $descripcion;
        $categoria->url = $url;
        $categoria->glosa = $glosa;
        $categoria->publicar = $publicar;
        $categoria->estado = $estado;
        
        $success = $categoria->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $categoria, "created") ;
        
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
    
      return redirect()->route('admin.categorias');
    
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

      $categoria = Categoria::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.categorias.form-edit-categoria')->with(compact('categoria'));
      }

      return view($this->prefixView.'.categorias.edit-categoria')->with(compact('categoria'));
    
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
      $familia_id = $request->input('familia_id');
      $cod_cat = $request->input('cod_cat');
      $descripcion = $request->input('descripcion');
      $url = $request->input('url');
      $glosa = $request->input('glosa');
      $imagen = $request->file('imagen');
      $img_bd     = $request->input('img_bd');
      $publicar = $request->input('publicar');

      if (!empty($id))
      {
        ##################################################################################
        $path_relative = "images/categorias/" ;
        $name_file     = "imagen";
        $image_url     = UploadFiles::uploadFile($request, $name_file , $path_relative);
        
        if(empty($image_url))
        {
          $image_url = $img_bd ;
        }
        
        $imagen    = $image_url ;
        ##################################################################################

        $categoria = Categoria::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $categoria->getAttributes();
        $categoria->id = $id;
        $categoria->familia_id = $familia_id;
        $categoria->cod_cat = $cod_cat;
        $categoria->descripcion = $descripcion;
        $categoria->url = $url;
        $categoria->glosa = $glosa;
        $categoria->imagen = $imagen;
        $categoria->publicar = $publicar;
        
        $success = $categoria->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $categoria, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.categorias');
    
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

      $categoria = Categoria::find( $id ) ;

      if (!empty($categoria))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $categoria->getAttributes();
        $categoria->estado = $estado;
        $categoria->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $categoria, "update estado", $attributes_old) ;
        
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

  public function updatePublish(Request $request )
  {
    try
    {
      $success = false;
      $message = "";

      $id = $request->input("id");
      $publicar = $request->input("publicar");

      if (!empty($id))
      {

        if ($publicar == "N") {
          $publicar = "S";
          $message = "Registro Publicado";
        } else {
          $publicar = "N";
          $message = "Registro Ocultado al público";
        }

        $categoria = Categoria::find($id);
        if (!empty($categoria))
        {
          $categoria->publicar = $publicar;
          $categoria->save();

          # TABLE BITACORA
          $this->savedBitacoraTrait( $categoria, "update publicar") ;

          $success = true;
          $message = $message;

         $data = $categoria;
        }
        else
        {
          $message = "¡El registro no exite o el identificador es incorrecto!";
          $data = $request->all();
        }
        
      }
      else
      {
        $message = "¡El identificador es incorrecto!";
        $data = $request->all();
      }

        return \Response::json([
                "message" => $message,
                "success"  => $success,
                "errors"  => [],
                "data"    => [$data],
              ]);
    
    }
    catch (\Exception $e)
    {
        return \Response::json([
                "message" => "Operación fallida en el servidor",
                "success"  => false,
                "errors"  => [$e->getMessage()],
                "data"    => [],
              ]);
    }

  }

  public function getPublished(  $params = array()  )
  {
    try
    {
      extract($params) ;

      $data = Categoria::where("publicar", $publicar)->get();

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

      $data = Categoria::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}