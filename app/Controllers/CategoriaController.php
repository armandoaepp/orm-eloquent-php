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
      if ($request->ajax()) {
        return view($this->prefixView.'.categorias.list-table-categoria');
      }

      return view($this->prefixView.'.categorias.list-categorias')->with(compact('data'));
    
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

  public function store(Request $request )
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
        
        $status = $categoria->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $categoria, "created") ;
        
        
      $message = "Operancion Correcta";
        

      $data = ["message" => $message, "status" => $status, "data" => [$categoria],];
    
      return redirect()->route('admin-categorias');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function edit( $id )
  {
    try
    {

      $categoria = Categoria::find( $id );

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
        $categoria->id = $id;
        $categoria->familia_id = $familia_id;
        $categoria->cod_cat = $cod_cat;
        $categoria->descripcion = $descripcion;
        $categoria->url = $url;
        $categoria->glosa = $glosa;
        $categoria->imagen = $imagen;
        $categoria->publicar = $publicar;
        
        $status = $categoria->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $categoria, "update") ;
        
        # remove imagen
        if($imagen != $img_bd && $status )
        {
          if (file_exists($img_bd))
            unlink($img_bd) ;
        }
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-categorias');;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function delete(Request $request )
  {
    try
    {
      $validator = \Validator::make($request->all(), [
        'id'     => 'numeric',
        'estado' => 'numeric',
      ]);

      $success = false;
      $message = "";

      if ($request->ajax())
      {
        if ($validator->fails())
        {
          return response()->json([
              "message" => "Error al realizar operación",
              "status"  => false,
              "errors"  => $validator->errors()->all(),
              "data"    => [],
            ]);
        }

        $id        = $request->input('id');
        $estado    = $request->input('estado');
        $historial = !empty($request->input('historial')) ? $request->input('historial') : "si";

        if ($estado == 1) {
          $estado = 0;
          $message = "Registro Desactivo Correctamente";
        } else {
          $estado = 1;
          $message = "Registro Activado Correctamente";
        }

        $categoria = Categoria::find( $id ) ;

        if (!empty($categoria))
        {
          #conservar en base de datos
          if ( $historial == "si" )
          {
            $categoria->estado = $estado;
            $categoria->save();
              
            # TABLE BITACORA
            $this->savedBitacoraTrait( $categoria, "update estado") ;
          
            $status = true;
            //$message = $message;
              
          }elseif( $historial == "no"  ) {
            $categoria->delete();
          
            # TABLE BITACORA
            $this->savedBitacoraTrait( $categoria, "destroy") ;
          
            $status = true;
            $message = "Registro eliminado de la base de datos";
          }
          
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
        abort(404);
      }
    
      return \Response::json([
                "message" => $message,
                "status"  => $status,
                "errors"  => [],
                "data"    => [$data],
              ]);
    
    }
    catch (\Throwable $e) 
    {
      return \Response::json([
                "message" => "Operación fallida en el servidor",
                "status"  => false,
                "errors"  => [$e->getMessage(), ],
                "data"    => [],
              ]);
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

          $status = true;
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
                "status"  => $status,
                "errors"  => [],
                "data"    => [$data],
              ]);
    
    }
    catch (\Exception $e)
    {
        return \Response::json([
                "message" => "Operación fallida en el servidor",
                "status"  => false,
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