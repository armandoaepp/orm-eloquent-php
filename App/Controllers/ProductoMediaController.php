<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\ProductoMedia; 
use App\Traits\BitacoraTrait;

class ProductoMediaController
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

      $data = ProductoMedia::get();

      return view('admin.producto-media.list-producto-media')->with(compact('data'));
    
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

      return view('admin.producto-media.new-producto-media');
    
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

      $producto_id = $request->input('producto_id');
      $tipo_media_id = $request->input('tipo_media_id');
      $pm_jerarquia = $request->input('pm_jerarquia');
      $pm_url = $request->input('pm_url');
      $pm_descripcion = $request->input('pm_descripcion');
      $pm_estado = $request->input('pm_estado');

      $producto_media = ProductoMedia::where(["producto_id" => $producto_id])->first();

      if (empty($producto_media))
      {
        $producto_media = new ProductoMedia();
        $producto_media->producto_id = $producto_id;
        $producto_media->tipo_media_id = $tipo_media_id;
        $producto_media->pm_jerarquia = $pm_jerarquia;
        $producto_media->pm_url = $pm_url;
        $producto_media->pm_descripcion = $pm_descripcion;
        $producto_media->pm_estado = $pm_estado;
        
        $status = $producto_media->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $producto_media, "created") ;
        
        $id = $producto_media->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$producto_media],];
    
      return redirect()->route('admin-producto-media');
    
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

      $data = ProductoMedia::find( $id );

      return view('admin.producto-media.edit-producto-media')->with(compact('data'));
    
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
      $producto_id = $request->input('producto_id');
      $tipo_media_id = $request->input('tipo_media_id');
      $pm_jerarquia = $request->input('pm_jerarquia');
      $pm_url = $request->input('pm_url');
      $pm_descripcion = $request->input('pm_descripcion');
      $pm_estado = $request->input('pm_estado');

      if (!empty($id))
      {
        $producto_media = ProductoMedia::find($id);
        $producto_media->id = $id;
        $producto_media->producto_id = $producto_id;
        $producto_media->tipo_media_id = $tipo_media_id;
        $producto_media->pm_jerarquia = $pm_jerarquia;
        $producto_media->pm_url = $pm_url;
        $producto_media->pm_descripcion = $pm_descripcion;
        $producto_media->pm_estado = $pm_estado;
        
        $status = $producto_media->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $producto_media, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-producto-media');;
    
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

      $producto_media = ProductoMedia::find( $id ) ;

      if (!empty($producto_media))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $producto_media->estado = $estado;
          $producto_media->save();
            
        # TABLE BITACORA
        $this->savedBitacoraTrait( $producto_media, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $producto_media->forceDelete();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $producto_media, "delete registro") ;
        
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

      $data = ProductoMedia::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}