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
use App\Traits\UploadFiles;

class ProductoController
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

      $data = Producto::get();

      return view($this->prefixView.'.productos.list-productos')->with(compact('data'));
    
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

      return view($this->prefixView.'.productos.new-producto');
    
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
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

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

      $producto = Producto::find( $id );

      return view($this->prefixView.'.productos.edit-producto')->with(compact('producto'));
    
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
        
        $data = $producto;
        
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

        $producto = Producto::find($id);
        if (!empty($producto))
        {
          $producto->publicar = $publicar;
          $producto->save();

          # TABLE BITACORA
          $this->savedBitacoraTrait( $producto, "update publicar: ".$publicar) ;

          $status = true;
          $message = $message;

         $data = $producto;
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

      $data = Producto::where("publicar", $publicar)->get();

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

      $data = Producto::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}