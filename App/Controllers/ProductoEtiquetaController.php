<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\ProductoEtiqueta; 
use App\Traits\BitacoraTrait;

class ProductoEtiquetaController
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

      $data = ProductoEtiqueta::get();

      return view('admin.producto-etiquetas.list-producto-etiquetas')->with(compact('data'));
    
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

      return view('admin.producto-etiquetas.new-producto-etiqueta');
    
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
      $etiqueta_id = $request->input('etiqueta_id');
      $pm_estado = $request->input('pm_estado');

      $producto_etiqueta = ProductoEtiqueta::where(["producto_id" => $producto_id])->first();

      if (empty($producto_etiqueta))
      {
        $producto_etiqueta = new ProductoEtiqueta();
        $producto_etiqueta->producto_id = $producto_id;
        $producto_etiqueta->etiqueta_id = $etiqueta_id;
        $producto_etiqueta->pm_estado = $pm_estado;
        
        $status = $producto_etiqueta->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $producto_etiqueta, "created") ;
        
        $id = $producto_etiqueta->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$producto_etiqueta],];
    
      return redirect()->route('admin-producto-etiquetas');
    
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

      $data = ProductoEtiqueta::find( $id );

      return view('admin.producto-etiquetas.edit-producto-etiqueta')->with(compact('data'));
    
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
      $etiqueta_id = $request->input('etiqueta_id');
      $pm_estado = $request->input('pm_estado');

      if (!empty($id))
      {
        $producto_etiqueta = ProductoEtiqueta::find($id);
        $producto_etiqueta->id = $id;
        $producto_etiqueta->producto_id = $producto_id;
        $producto_etiqueta->etiqueta_id = $etiqueta_id;
        $producto_etiqueta->pm_estado = $pm_estado;
        
        $status = $producto_etiqueta->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $producto_etiqueta, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-producto-etiquetas');;
    
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

      $producto_etiqueta = ProductoEtiqueta::find( $id ) ;

      if (!empty($producto_etiqueta))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $producto_etiqueta->estado = $estado;
          $producto_etiqueta->save();
            
        # TABLE BITACORA
        $this->savedBitacoraTrait( $producto_etiqueta, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $producto_etiqueta->forceDelete();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $producto_etiqueta, "delete registro") ;
        
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

      $data = ProductoEtiqueta::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}