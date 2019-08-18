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

class SubCategoriaController
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

      $data = SubCategoria::get();

      return view('admin.sub-categorias.list-sub-categorias')->with(compact('data'));
    
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

      return view('admin.sub-categorias.new-sub-categoria');
    
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
      $sc_imagen = $request->input('sc_imagen');
      $sc_publicar = $request->input('sc_publicar');
      $sc_estado = $request->input('sc_estado');

      $sub_categoria = SubCategoria::where(["categoria_id" => $categoria_id])->first();

      if (empty($sub_categoria))
      {
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

      $data = SubCategoria::find( $id );

      return view('admin.sub-categorias.edit-sub-categoria')->with(compact('data'));
    
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
      $sc_imagen = $request->input('sc_imagen');
      $sc_publicar = $request->input('sc_publicar');
      $sc_estado = $request->input('sc_estado');

      if (!empty($id))
      {
        $sub_categoria = SubCategoria::find($id);
        $sub_categoria->id = $id;
        $sub_categoria->categoria_id = $categoria_id;
        $sub_categoria->sc_descripcion = $sc_descripcion;
        $sub_categoria->sc_imagen = $sc_imagen;
        $sub_categoria->sc_publicar = $sc_publicar;
        $sub_categoria->sc_estado = $sc_estado;
        
        $status = $sub_categoria->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $sub_categoria, "update") ;
        
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
          $sub_categoria->estado = $estado;
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

      $data = SubCategoria::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}