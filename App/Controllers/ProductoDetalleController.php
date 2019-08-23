<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\ProductoDetalle; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class ProductoDetalleController
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

      $data = ProductoDetalle::get();

      return view($this->prefixView.'.producto-detalles.list-producto-detalles')->with(compact('data'));
    
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

      return view($this->prefixView.'.producto-detalles.new-producto-detalle');
    
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

      $producto_id = $request->input('producto_id');
      $pd_descripcion = $request->input('pd_descripcion');
      $pd_estado = !empty($request->input('pd_estado')) ? $request->input('pd_estado') : 1;

      $producto_detalle = ProductoDetalle::where(["producto_id" => $producto_id])->first();

      if (empty($producto_detalle))
      {

        $producto_detalle = new ProductoDetalle();
        $producto_detalle->producto_id = $producto_id;
        $producto_detalle->pd_descripcion = $pd_descripcion;
        $producto_detalle->pd_estado = $pd_estado;
        
        $status = $producto_detalle->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $producto_detalle, "created") ;
        
        $id = $producto_detalle->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$producto_detalle],];
    
      return redirect()->route('admin-producto-detalles');
    
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

      $producto_detalle = ProductoDetalle::find( $id );

      return view($this->prefixView.'.producto-detalles.edit-producto-detalle')->with(compact('producto_detalle'));
    
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
      $pd_descripcion = $request->input('pd_descripcion');

      if (!empty($id))
      {
        $producto_detalle = ProductoDetalle::find($id);
        $producto_detalle->id = $id;
        $producto_detalle->producto_id = $producto_id;
        $producto_detalle->pd_descripcion = $pd_descripcion;
        
        $status = $producto_detalle->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $producto_detalle, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-producto-detalles');;
    
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

      $producto_detalle = ProductoDetalle::find( $id ) ;

      if (!empty($producto_detalle))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $producto_detalle->pd_estado = $estado;
          $producto_detalle->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $producto_detalle, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $producto_detalle->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $producto_detalle, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $producto_detalle;
        
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

  public function find( $id )
  {
    try
    {

      $data = ProductoDetalle::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}