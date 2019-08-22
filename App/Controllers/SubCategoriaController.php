<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
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

  public function getAll()
  {
    try
    {

      $data = SubCategoria::get();

      return view($this->prefixView.'.sub-categorias.list-sub-categorias')->with(compact('data'));
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function newRegister( Request $request )
  {
    try
    {

      return view($this->prefixView.'.sub-categorias.new-sub-categoria');
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function save( Request $request )
  {
    try
    {
      $status  = false;
      $message = "";

      $categoria_id = $request->input('categoria_id');
      $sc_descripcion = $request->input('sc_descripcion');
      $sc_imagen = $request->file('sc_imagen');
      $sc_publicar = $request->input('sc_publicar');
      $sc_estado = $request->input('sc_estado');

      $sub_categoria = SubCategoria::where(["categoria_id" => $categoria_id])->first();

      if (empty($sub_categoria))
      {

        ##################################################################################
        $path_relative = "images/sub_categorias/" ;
        $name_file     = "sc_imagen";
        $image_url     = UploadFiles::uploadFile($request, $name_file , $path_relative);
        $sc_imagen    = $image_url ;
        ##################################################################################

        $sub_categoria = new SubCategoria();
        $sub_categoria->categoria_id = $categoria_id;
        $sub_categoria->sc_descripcion = $sc_descripcion;
        $sub_categoria->sc_imagen = $sc_imagen;
        $sub_categoria->sc_publicar = $sc_publicar;
        $sub_categoria->sc_estado = $sc_estado;
        
        $status = $sub_categoria->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $sub_categoria, "created") ;
        
        $id = $sub_categoria->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$sub_categoria],];
    
      return redirect()->route('admin-sub-categorias');
    
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

      $sub_categoria = SubCategoria::find( $id );

      return view($this->prefixView.'.sub-categorias.edit-sub-categoria')->with(compact('sub_categoria'));
    
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
      $categoria_id = $request->input('categoria_id');
      $sc_descripcion = $request->input('sc_descripcion');
      $sc_imagen = $request->file('sc_imagen');
      $img_bd     = $request->input('img_bd');
      $sc_publicar = $request->input('sc_publicar');

      if (!empty($id))
      {
        ##################################################################################
        $path_relative = "images/sub_categorias/" ;
        $name_file     = "sc_imagen";
        $image_url     = UploadFiles::uploadFile($request, $name_file , $path_relative);
        
        if(empty($image_url))
        {
          $image_url = $img_bd ;
        }
        
        $sc_imagen    = $image_url ;
        ##################################################################################

        $sub_categoria = SubCategoria::find($id);
        $sub_categoria->id = $id;
        $sub_categoria->categoria_id = $categoria_id;
        $sub_categoria->sc_descripcion = $sc_descripcion;
        $sub_categoria->sc_imagen = $sc_imagen;
        $sub_categoria->sc_publicar = $sc_publicar;
        
        $status = $sub_categoria->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $sub_categoria, "update") ;
        
        # remove imagen
        if($sc_imagen != $img_bd && $status )
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
    
      return redirect()->route('admin-sub-categorias');;
    
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

      $sub_categoria = SubCategoria::find( $id ) ;

      if (!empty($sub_categoria))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $sub_categoria->sc_estado = $estado;
          $sub_categoria->save();
            
        # TABLE BITACORA
        $this->savedBitacoraTrait( $sub_categoria, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $sub_categoria->forceDelete();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $sub_categoria, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
         $data = $plan;
        
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

        $sub_categoria = SubCategoria::find($id);
        if ($sub_categoria)
        {
          $sub_categoria->sc_publicar = $publicar;
          $sub_categoria->save();

          # TABLE BITACORA
          $this->savedBitacoraTrait( $sub_categoria, "update publicar: ".$publicar) ;

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

      $data = SubCategoria::where("sc_publicar", $sc_publicar)->get();

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

      $data = SubCategoria::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}