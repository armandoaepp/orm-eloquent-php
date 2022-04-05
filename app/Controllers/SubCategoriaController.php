<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\SubCategoria; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class SubCategoriaController
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

      $data = SubCategoria::get();

      return view($this->prefixView.'.sub-categorias.list-sub-categorias')->with(compact('data'));
    
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

      $data = SubCategoria::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.sub-categorias.list-table-sub-categorias')->with(compact('data'));
    
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
        return view($this->prefixView.'.sub-categorias.form-create-sub-categoria');
      }

      return view($this->prefixView.'.sub-categorias.new-sub-categoria');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(SubCategoriaStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $categoria_id = $request->input('categoria_id');
      $cod_subcat = $request->input('cod_subcat');
      $descripcion = $request->input('descripcion');
      $url = $request->input('url');
      $glosa = $request->input('glosa');
      $imagen = $request->file('imagen');
      $publicar = $request->input('publicar');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        ##################################################################################
        $path_relative = "images/sub_categorias/" ;
        $name_file     = "imagen";
        $image_url     = UploadFiles::uploadFile($request, $name_file , $path_relative);
        $imagen    = $image_url ;
        ##################################################################################

        $sub_categoria = new SubCategoria();
        $sub_categoria->categoria_id = $categoria_id;
        $sub_categoria->cod_subcat = $cod_subcat;
        $sub_categoria->descripcion = $descripcion;
        $sub_categoria->url = $url;
        $sub_categoria->glosa = $glosa;
        $sub_categoria->publicar = $publicar;
        $sub_categoria->estado = $estado;
        
        $success = $sub_categoria->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $sub_categoria, "created") ;
        
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
    
      return redirect()->route('admin.sub-categorias');
    
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

      $sub_categoria = SubCategoria::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.sub-categorias.form-edit-sub-categoria')->with(compact('sub_categoria'));
      }

      return view($this->prefixView.'.sub-categorias.edit-sub-categoria')->with(compact('sub_categoria'));
    
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
      $categoria_id = $request->input('categoria_id');
      $cod_subcat = $request->input('cod_subcat');
      $descripcion = $request->input('descripcion');
      $url = $request->input('url');
      $glosa = $request->input('glosa');
      $imagen = $request->file('imagen');
      $img_bd     = $request->input('img_bd');
      $publicar = $request->input('publicar');

      if (!empty($id))
      {
        ##################################################################################
        $path_relative = "images/sub_categorias/" ;
        $name_file     = "imagen";
        $image_url     = UploadFiles::uploadFile($request, $name_file , $path_relative);
        
        if(empty($image_url))
        {
          $image_url = $img_bd ;
        }
        
        $imagen    = $image_url ;
        ##################################################################################

        $sub_categoria = SubCategoria::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $sub_categoria->getAttributes();
        $sub_categoria->id = $id;
        $sub_categoria->categoria_id = $categoria_id;
        $sub_categoria->cod_subcat = $cod_subcat;
        $sub_categoria->descripcion = $descripcion;
        $sub_categoria->url = $url;
        $sub_categoria->glosa = $glosa;
        $sub_categoria->imagen = $imagen;
        $sub_categoria->publicar = $publicar;
        
        $success = $sub_categoria->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $sub_categoria, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.sub-categorias');
    
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

      $sub_categoria = SubCategoria::find( $id ) ;

      if (!empty($sub_categoria))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $sub_categoria->getAttributes();
        $sub_categoria->estado = $estado;
        $sub_categoria->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $sub_categoria, "update estado", $attributes_old) ;
        
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

      $sub_categoria = SubCategoria::find( $id ) ;

      if (!empty($sub_categoria))
      {

        $sub_categoria->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $sub_categoria, "destroy") ;
        
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

      $validator = \Validator::make($request->all(), [
        'id'     => 'required|numeric',
        'publicar'     => 'required|numeric',
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

      $id = $request->input("id");
      $publicar = $request->input("publicar");

      if (!empty($id))
      {

        if ($publicar == "S") {
          $message = "Registro PUBLICADO Correctamente";
        } else {
          $message = "Registro OCULTADO al Público Correctamente";
        }

        $sub_categoria = SubCategoria::find($id);
        if (!empty($sub_categoria))
        {

          # Values OLD FOR BITACORA
          $attributes_old = sub_categoria->getAttributes(); $sub_categoria->publicar = $publicar;

          $sub_categoria->publicar = $publicar;
          $sub_categoria->save();

          # TABLE BITACORA
          $this->savedBitacoraTrait( $sub_categoria, "update publicar", $attributes_old) ;

          $success = true;
          $code = 200;

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

      $data = SubCategoria::where("publicar", $publicar)->get();

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

      $data = SubCategoria::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}