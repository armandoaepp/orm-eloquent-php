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

class CategoriaController
{
  use BitacoraTrait;

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function getAll()
  {
    try
    {

      $data = Categoria::get();

      return view('admin.categorias.list-categorias')->with(compact('data'));
    
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

      return view('admin.categorias.new-categoria');
    
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

      $cat_descripcion = $request->input('cat_descripcion');
      $cat_imagen = $request->input('cat_imagen');
      $estado = $request->input('estado');
      $cat_publicar = $request->input('cat_publicar');

      $categoria = Categoria::where(["cat_descripcion" => $cat_descripcion])->first();

      if (empty($categoria))
      {
        $categoria = new Categoria();
        $categoria->cat_descripcion = $cat_descripcion;
        $categoria->cat_imagen = $cat_imagen;
        $categoria->estado = $estado;
        $categoria->cat_publicar = $cat_publicar;
        
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

      $data = Categoria::find( $id );

      return view('admin.categorias.edit-categoria')->with(compact('data'));
    
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
      $cat_imagen = $request->input('cat_imagen');
      $cat_publicar = $request->input('cat_publicar');

      if (!empty($id))
      {
        $categoria = Categoria::find($id);
        $categoria->id = $id;
        $categoria->cat_descripcion = $cat_descripcion;
        $categoria->cat_imagen = $cat_imagen;
        $categoria->cat_publicar = $cat_publicar;
        
        $status = $categoria->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $categoria, "update") ;
        
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
          $categoria->estado = $estado;
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
                "status"  => $status,
                "errors"  => [$e->getMessage(), ],
                "data"    => [],
              ]);
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

  public function updateStatus( $params = array() )
  {
    try
    {
      extract($params) ;

      $status  = false;
      $message = "";

      if (empty($id))
      {
        $categoria = Categoria::find($id);
        $categoria->estado = $estado;
        
        $status = $categoria->save();
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El identificador es incorrecto!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function getByStatus( $params = array()  )
  {
    try
    {
      extract($params) ;

      $data = Categoria::where("estado", $estado)->get();

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}