<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
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

  public function getAll()
  {
    try
    {

      $data = Categoria::get();

      return view($this->prefixView.'.categorias.list-categorias')->with(compact('data'));
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function create( Request $request )
  {
    try
    {

      return view($this->prefixView.'.categorias.new-categoria');
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function store( Request $request )
  {
    try
    {
      $status  = false;
      $message = "";

      $cat_descripcion = $request->input('cat_descripcion');
      $cat_imagen = $request->file('cat_imagen');
      $cat_publicar = $request->input('cat_publicar');
      $cat_estado = !empty($request->input('cat_estado')) ? $request->input('cat_estado') : 1;

      $categoria = Categoria::where(["cat_descripcion" => $cat_descripcion])->first();

      if (empty($categoria))
      {

        ##################################################################################
        $path_relative = "images/categorias/" ;
        $name_file     = "cat_imagen";
        $image_url     = UploadFiles::uploadFile($request, $name_file , $path_relative);
        $cat_imagen    = $image_url ;
        ##################################################################################

        $categoria = new Categoria();
        $categoria->cat_descripcion = $cat_descripcion;
        $categoria->cat_imagen = $cat_imagen;
        $categoria->cat_publicar = $cat_publicar;
        $categoria->cat_estado = $cat_estado;
        
        $status = $categoria->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $categoria, "created") ;
        
        $id = $categoria->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$categoria],];
    
      return redirect()->route('admin-categorias');
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function edit( $id )
  {
    try
    {

      $categoria = Categoria::find( $id );

      return view($this->prefixView.'.categorias.edit-categoria')->with(compact('categoria'));
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function update( Request $request )
  {
    try
    {

      $status  = false;
      $message = "";

      $id = $request->input('id');
      $cat_descripcion = $request->input('cat_descripcion');
      $cat_imagen = $request->file('cat_imagen');
      $img_bd     = $request->input('img_bd');
      $cat_publicar = $request->input('cat_publicar');

      if (!empty($id))
      {
        ##################################################################################
        $path_relative = "images/categorias/" ;
        $name_file     = "cat_imagen";
        $image_url     = UploadFiles::uploadFile($request, $name_file , $path_relative);
        
        if(empty($image_url))
        {
          $image_url = $img_bd ;
        }
        
        $cat_imagen    = $image_url ;
        ##################################################################################

        $categoria = Categoria::find($id);
        $categoria->id = $id;
        $categoria->cat_descripcion = $cat_descripcion;
        $categoria->cat_imagen = $cat_imagen;
        $categoria->cat_publicar = $cat_publicar;
        
        $status = $categoria->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $categoria, "update") ;
        
        # remove imagen
        if($cat_imagen != $img_bd && $status )
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
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function delete( Request $request )
  {
    try
    {
      $status  = false;
      $message = "";

      $id = $request->input('id');
      $estado = $request->input('estado');
      $historial = !empty($request->input('historial')) ? $request->input('historial') : "si";

      if ($estado == 1) {
        $estado = 0;
      } else {
        $estado = 1;
      }

      $categoria = Categoria::find( $id ) ;

      if (!empty($categoria))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $categoria->cat_estado = $estado;
          $categoria->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $categoria, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $categoria->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $categoria, "delete registro") ;
        
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

  public function updatePublish( Request $request )
  {
    try
    {
      $status  = false;
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
          $categoria->cat_publicar = $publicar;
          $categoria->save();

          # TABLE BITACORA
          $this->savedBitacoraTrait( $categoria, "update publicar: ".$publicar) ;

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
    catch (Exception $e)
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

      $data = Categoria::where("cat_publicar", $cat_publicar)->get();

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function find( $id )
  {
    try
    {

      $data = Categoria::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}