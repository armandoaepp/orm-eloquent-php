<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
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

  public function index()
  {
    try
    {

      $data = Producto::get();

      return view($this->prefixView.'.productos.list-productos')->with(compact('data'));
    
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

      $data = Producto::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.productos.list-table-productos')->with(compact('data'));
    
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
        return view($this->prefixView.'.productos.form-create-producto');
      }

      return view($this->prefixView.'.productos.new-producto');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(ProductoStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $sede_id = $request->input('sede_id');
      $cod_min = $request->input('cod_min');
      $descripcion = $request->input('descripcion');
      $cod_lg = $request->input('cod_lg');
      $cod_bar = $request->input('cod_bar');
      $url = $request->input('url');
      $sub_categoria_id = $request->input('sub_categoria_id');
      $categoria_id = $request->input('categoria_id');
      $familia_id = $request->input('familia_id');
      $proveedor_id = $request->input('proveedor_id');
      $modelo_id = $request->input('modelo_id');
      $marca_id = $request->input('marca_id');
      $glosa = $request->input('glosa');
      $publicar = $request->input('publicar');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $producto = new Producto();
        $producto->sede_id = $sede_id;
        $producto->cod_min = $cod_min;
        $producto->descripcion = $descripcion;
        $producto->cod_lg = $cod_lg;
        $producto->cod_bar = $cod_bar;
        $producto->url = $url;
        $producto->sub_categoria_id = $sub_categoria_id;
        $producto->categoria_id = $categoria_id;
        $producto->familia_id = $familia_id;
        $producto->proveedor_id = $proveedor_id;
        $producto->modelo_id = $modelo_id;
        $producto->marca_id = $marca_id;
        $producto->glosa = $glosa;
        $producto->publicar = $publicar;
        $producto->estado = $estado;
        
        $success = $producto->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $producto, "created") ;
        
      $message = "Datos Registrados Correctamente";
        
      if ($request->ajax()) {
        return response()->json([
          "message" => $message,
          "code"    => 200,
          "success"  => $success,
          "errors"  => [],
          "data"    => [],
        ]);
      };
    
      return redirect()->route('admin.productos');
    
    }
    catch (\Exception $e)
    {

      if ($request->ajax()) {
        return response()->json([
          "message" => "Operación fallida en el servidor",
          "code"    => 500,
          "success"  => false,
          "errors"  => [$e->getMessage()],
          "data"    => []
        ]);
      }

      throw new \Exception($e->getMessage());
    }

  }

  public function edit( $id, Request $request)
  {
    try
    {

      $producto = Producto::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.productos.form-edit-producto')->with(compact('producto'));
      }

      return view($this->prefixView.'.productos.edit-producto')->with(compact('producto'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function update(ProductoUpdateRequest $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id = $request->input('id');
      $sede_id = $request->input('sede_id');
      $cod_min = $request->input('cod_min');
      $descripcion = $request->input('descripcion');
      $cod_lg = $request->input('cod_lg');
      $cod_bar = $request->input('cod_bar');
      $url = $request->input('url');
      $sub_categoria_id = $request->input('sub_categoria_id');
      $categoria_id = $request->input('categoria_id');
      $familia_id = $request->input('familia_id');
      $proveedor_id = $request->input('proveedor_id');
      $modelo_id = $request->input('modelo_id');
      $marca_id = $request->input('marca_id');
      $glosa = $request->input('glosa');
      $publicar = $request->input('publicar');

      if (!empty($id))
      {
        $producto = Producto::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $producto->getAttributes();

        $producto->id = $id;
        $producto->sede_id = $sede_id;
        $producto->cod_min = $cod_min;
        $producto->descripcion = $descripcion;
        $producto->cod_lg = $cod_lg;
        $producto->cod_bar = $cod_bar;
        $producto->url = $url;
        $producto->sub_categoria_id = $sub_categoria_id;
        $producto->categoria_id = $categoria_id;
        $producto->familia_id = $familia_id;
        $producto->proveedor_id = $proveedor_id;
        $producto->modelo_id = $modelo_id;
        $producto->marca_id = $marca_id;
        $producto->glosa = $glosa;
        $producto->publicar = $publicar;
        
        $success = $producto->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $producto, "update", $attributes_old) ;
        
        $message = "Datos Actualizados Correctamente";
        $code = 200;
        
      }
      else
      {
        $message = "¡El registro NO existe!";
        $code = 406;
      }

      if ($request->ajax()) {
        return response()->json([
          "message" => $message,
          "code"    => $code,
          "success"  => $success,
          "errors"  => [],
          "data"    => [],
        ]);
      };

      return redirect()->route('admin.productos');
    
    }
    catch (\Exception $e)
    {

      if ($request->ajax()) {
        return response()->json([
          "message" => "Operación fallida en el servidor",
          "code"    => 500,
          "success" => false,
          "errors"  => [$e->getMessage()],
          "data"    => []
        ]);
      }

      throw new \Exception($e->getMessage());
    }

  }

  public function delete(EstadoIdRequest $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id        = $request->input('id');
      $estado    = $request->input('estado');

      if ($estado == 1) {
        $message = "Registro Activado Correctamente";
      } else {
        $message = "Registro Desactivo Correctamente";
      }

      $producto = Producto::find( $id ) ;

      if (!empty($producto))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $producto->getAttributes();

        $producto->estado = $estado;
        $producto->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $producto, "update estado", $attributes_old) ;
        
        $success = true;
        $code = 200;
      } else {
        $message = "¡El registro no exite o el identificador es incorrecto!";
        $success  = false;
        $code = 400;
      }  
        
      if ($request->ajax()) {
        return response()->json([
          "message" => $message,
          "code"    => $code,
          "success" => $success,
          "errors"  => [],
          "data"    => [],
        ]);
      };
        
    }
    catch (\Throwable $e) 
    {

      if ($request->ajax()) {
        return response()->json([
          "message" => "Operación fallida en el servidor",
          "code"    => 500,
          "success"  => false,
          "errors"  => [$e->getMessage()],
          "data"    => []
        ]);
      }

      throw new \Exception($e->getMessage());
    }

  }

  public function destroy(Request $request )
  {
    try
    {
      $validator = \Validator::make($request->all(), [
        'id'     => 'numeric',
      ]);
      if ($validator->fails())
      {
        if ($request->ajax())
        {
          return response()->json([
            "message" => "Error al realizar operación",
            "code"    => 400,
            "success" => false,
            "errors"  => $validator->errors()->all(),
            "data"    => [],
            ]);
        }
      }


      $success = false;
      $message = "";

      $id = $request->input('id');

      $producto = Producto::find( $id ) ;

      if (!empty($producto))
      {

        $producto->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $producto, "destroy") ;
        
        $success = true;
        $code = 200;
        $message = "Registro Borrado Correctamente";
      } else {
        $message = "¡El registro no exite o el identificador es incorrecto!";
        $success  = false;
        $code = 400;
      }  
        
      if ($request->ajax()) {
        return response()->json([
          "message" => $message,
          "code"    => $code,
          "success" => $success,
          "errors"  => [],
          "data"    => [],
        ]);
      }
        
    }
    catch (\Throwable $e) 
    {

      if ($request->ajax()) {
        return response()->json([
          "message" => "Operación fallida en el servidor",
          "code"    => 500,
          "success" => false,
          "errors"  => [$e->getMessage()],
          "data"    => []
        ]);
      }

      throw new \Exception($e->getMessage());
    }

  }

  public function updatePublish(Request $request )
  {
    try
    {
      $success = false;
      $message = "";

      $validator = \Validator::make($request->all(), [
        'id'       => 'required|numeric',
        'publicar' => 'required|max:2',
      ]);

      if ($validator->fails())
      {
        if ($request->ajax())
        {
          return response()->json([
            "message" => "Error al realizar operación",
            "code"    => 400,
            "success" => false,
            "errors"  => $validator->errors()->all(),
            "data"    => [],
            ]);
        }
      }

      $id = $request->input("id");
      $publicar = $request->input("publicar");

      if (!empty($id))
      {

        if ($publicar == "S") {
          $message = "Registro PUBLICADO Correctamente";
        } else {
          $message = "Registro OCULTADO al Público Correctamente";
        }

        $producto = Producto::find($id);
        if (!empty($producto))
        {

          # Values OLD FOR BITACORA
          $attributes_old = $producto->getAttributes(); 

          $producto->publicar = $publicar;
          $producto->save();

          # TABLE BITACORA
          $this->savedBitacoraTrait( $producto, "update publicar", $attributes_old) ;

          $success = true;
          $code = 200;

        }
        else
        {
          $message = "¡El registro no exite o el identificador es incorrecto!";
          $code = 400;
        }
        
      }
      else
      {
        $message = "¡El identificador es incorrecto!";
        $code = 400;
      }

      if ($request->ajax()) {
        return response()->json([
          "message" => $message,
          "code"    => $code,
          "success" => $success,
          "errors"  => [],
          "data"    => [],
        ]);
      };
    
    }
    catch (\Exception $e)
    {

      if ($request->ajax()) {
        return response()->json([
          "message" => "Operación fallida en el servidor",
          "code"    => 500,
          "success" => false,
          "errors"  => [$e->getMessage()],
          "data"    => []
        ]);
      }

      throw new \Exception($e->getMessage());
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
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function find( $id )
  {
    try
    {

      $data = Producto::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}