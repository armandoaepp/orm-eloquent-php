<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Producto; 
use App\Traits\BitacoraTrait;

class ProductoController
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

      $data = Producto::get();

      return view('admin.productos.list-productos')->with(compact('data'));
    
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

      return view('admin.productos.new-producto');
    
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

      $sub_categoria_id = $request->input('sub_categoria_id');
      $categoria_id = $request->input('categoria_id');
      $codigo = $request->input('codigo');
      $descripcion = $request->input('descripcion');
      $glosa = $request->input('glosa');
      $precio = $request->input('precio');
      $descuento = $request->input('descuento');
      $precio_descuento = $request->input('precio_descuento');
      $num_visitas = $request->input('num_visitas');
      $publicar = $request->input('publicar');
      $estado = $request->input('estado');

      $producto = Producto::where(["sub_categoria_id" => $sub_categoria_id])->first();

      if (empty($producto))
      {
        $producto = new Producto();
        $producto->sub_categoria_id = $sub_categoria_id;
        $producto->categoria_id = $categoria_id;
        $producto->codigo = $codigo;
        $producto->descripcion = $descripcion;
        $producto->glosa = $glosa;
        $producto->precio = $precio;
        $producto->descuento = $descuento;
        $producto->precio_descuento = $precio_descuento;
        $producto->num_visitas = $num_visitas;
        $producto->publicar = $publicar;
        $producto->estado = $estado;
        
        $status = $producto->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $producto, "created") ;
        
        $id = $producto->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$producto],];
    
      return redirect()->route('admin-productos');
    
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

      $data = Producto::find( $id );

      return view('admin.productos.edit-producto')->with(compact('data'));
    
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
      $sub_categoria_id = $request->input('sub_categoria_id');
      $categoria_id = $request->input('categoria_id');
      $codigo = $request->input('codigo');
      $descripcion = $request->input('descripcion');
      $glosa = $request->input('glosa');
      $precio = $request->input('precio');
      $descuento = $request->input('descuento');
      $precio_descuento = $request->input('precio_descuento');
      $num_visitas = $request->input('num_visitas');
      $publicar = $request->input('publicar');

      if (!empty($id))
      {
        $producto = Producto::find($id);
        $producto->id = $id;
        $producto->sub_categoria_id = $sub_categoria_id;
        $producto->categoria_id = $categoria_id;
        $producto->codigo = $codigo;
        $producto->descripcion = $descripcion;
        $producto->glosa = $glosa;
        $producto->precio = $precio;
        $producto->descuento = $descuento;
        $producto->precio_descuento = $precio_descuento;
        $producto->num_visitas = $num_visitas;
        $producto->publicar = $publicar;
        
        $status = $producto->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $producto, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-productos');;
    
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

      $producto = Producto::find( $id ) ;

      if (!empty($producto))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $producto->estado = $estado;
          $producto->save();
            
        # TABLE BITACORA
        $this->savedBitacoraTrait( $producto, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $producto->forceDelete();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $producto, "delete registro") ;
        
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

      $data = Producto::find($id);

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
        $producto = Producto::find($id);
        $producto->estado = $estado;
        
        $status = $producto->save();
        
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

      $data = Producto::where("estado", $estado)->get();

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}