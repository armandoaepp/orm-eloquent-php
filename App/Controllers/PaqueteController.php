<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Paquete; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PaqueteController
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

      $data = Paquete::get();

      return view($this->prefixView.'.paquetes.list-paquetes')->with(compact('data'));
    
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

      return view($this->prefixView.'.paquetes.new-paquete');
    
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

      $ubigeo_id = $request->input('ubigeo_id');
      $nombre = $request->input('nombre');
      $descripcion = $request->input('descripcion');
      $recomendacion = $request->input('recomendacion');
      $num_dias = $request->input('num_dias');
      $num_noches = $request->input('num_noches');
      $precio = $request->input('precio');
      $descuento = $request->input('descuento');
      $precio_descuento = $request->input('precio_descuento');
      $fecha_ini_promo = $request->input('fecha_ini_promo');
      $fecha_fin_promo = $request->input('fecha_fin_promo');
      $url = $request->input('url');
      $num_visitas = $request->input('num_visitas');
      $publicar = $request->input('publicar');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      $paquete = Paquete::where(["ubigeo_id" => $ubigeo_id])->first();

      if (empty($paquete))
      {

        $paquete = new Paquete();
        $paquete->ubigeo_id = $ubigeo_id;
        $paquete->nombre = $nombre;
        $paquete->descripcion = $descripcion;
        $paquete->recomendacion = $recomendacion;
        $paquete->num_dias = $num_dias;
        $paquete->num_noches = $num_noches;
        $paquete->precio = $precio;
        $paquete->descuento = $descuento;
        $paquete->precio_descuento = $precio_descuento;
        $paquete->fecha_ini_promo = $fecha_ini_promo;
        $paquete->fecha_fin_promo = $fecha_fin_promo;
        $paquete->url = $url;
        $paquete->num_visitas = $num_visitas;
        $paquete->publicar = $publicar;
        $paquete->estado = $estado;
        
        $status = $paquete->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $paquete, "created") ;
        
        $id = $paquete->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$paquete],];
    
      return redirect()->route('admin-paquetes');
    
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

      $paquete = Paquete::find( $id );

      return view($this->prefixView.'.paquetes.edit-paquete')->with(compact('paquete'));
    
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
      $ubigeo_id = $request->input('ubigeo_id');
      $nombre = $request->input('nombre');
      $descripcion = $request->input('descripcion');
      $recomendacion = $request->input('recomendacion');
      $num_dias = $request->input('num_dias');
      $num_noches = $request->input('num_noches');
      $precio = $request->input('precio');
      $descuento = $request->input('descuento');
      $precio_descuento = $request->input('precio_descuento');
      $fecha_ini_promo = $request->input('fecha_ini_promo');
      $fecha_fin_promo = $request->input('fecha_fin_promo');
      $url = $request->input('url');
      $num_visitas = $request->input('num_visitas');
      $publicar = $request->input('publicar');

      if (!empty($id))
      {
        $paquete = Paquete::find($id);
        $paquete->id = $id;
        $paquete->ubigeo_id = $ubigeo_id;
        $paquete->nombre = $nombre;
        $paquete->descripcion = $descripcion;
        $paquete->recomendacion = $recomendacion;
        $paquete->num_dias = $num_dias;
        $paquete->num_noches = $num_noches;
        $paquete->precio = $precio;
        $paquete->descuento = $descuento;
        $paquete->precio_descuento = $precio_descuento;
        $paquete->fecha_ini_promo = $fecha_ini_promo;
        $paquete->fecha_fin_promo = $fecha_fin_promo;
        $paquete->url = $url;
        $paquete->num_visitas = $num_visitas;
        $paquete->publicar = $publicar;
        
        $status = $paquete->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $paquete, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-paquetes');;
    
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

      $paquete = Paquete::find( $id ) ;

      if (!empty($paquete))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $paquete->estado = $estado;
          $paquete->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $paquete, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $paquete->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $paquete, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $paquete;
        
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

        $paquete = Paquete::find($id);
        if (!empty($paquete))
        {
          $paquete->publicar = $publicar;
          $paquete->save();

          # TABLE BITACORA
          $this->savedBitacoraTrait( $paquete, "update publicar: ".$publicar) ;

          $status = true;
          $message = $message;

         $data = $paquete;
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

      $data = Paquete::where("publicar", $publicar)->get();

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

      $data = Paquete::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}