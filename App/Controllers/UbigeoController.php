<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Ubigeo; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class UbigeoController
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

      $data = Ubigeo::get();

      return view($this->prefixView.'.ubigeos.list-ubigeos')->with(compact('data'));
    
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

      return view($this->prefixView.'.ubigeos.new-ubigeo');
    
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

      $pais_id = $request->input('pais_id');
      $ubigeo_id_padre = $request->input('ubigeo_id_padre');
      $ubi_codigo = $request->input('ubi_codigo');
      $ubi_ubigeo = $request->input('ubi_ubigeo');
      $ubi_descripcion = $request->input('ubi_descripcion');
      $tipo_ubigeo_id = $request->input('tipo_ubigeo_id');
      $ubi_estado = !empty($request->input('ubi_estado')) ? $request->input('ubi_estado') : 1;

      $ubigeo = Ubigeo::where(["pais_id" => $pais_id])->first();

      if (empty($ubigeo))
      {

        $ubigeo = new Ubigeo();
        $ubigeo->pais_id = $pais_id;
        $ubigeo->ubigeo_id_padre = $ubigeo_id_padre;
        $ubigeo->ubi_codigo = $ubi_codigo;
        $ubigeo->ubi_ubigeo = $ubi_ubigeo;
        $ubigeo->ubi_descripcion = $ubi_descripcion;
        $ubigeo->tipo_ubigeo_id = $tipo_ubigeo_id;
        $ubigeo->ubi_estado = $ubi_estado;
        
        $status = $ubigeo->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $ubigeo, "created") ;
        
        $id = $ubigeo->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$ubigeo],];
    
      return redirect()->route('admin-ubigeos');
    
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

      $ubigeo = Ubigeo::find( $id );

      return view($this->prefixView.'.ubigeos.edit-ubigeo')->with(compact('ubigeo'));
    
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
      $pais_id = $request->input('pais_id');
      $ubigeo_id_padre = $request->input('ubigeo_id_padre');
      $ubi_codigo = $request->input('ubi_codigo');
      $ubi_ubigeo = $request->input('ubi_ubigeo');
      $ubi_descripcion = $request->input('ubi_descripcion');
      $tipo_ubigeo_id = $request->input('tipo_ubigeo_id');

      if (!empty($id))
      {
        $ubigeo = Ubigeo::find($id);
        $ubigeo->id = $id;
        $ubigeo->pais_id = $pais_id;
        $ubigeo->ubigeo_id_padre = $ubigeo_id_padre;
        $ubigeo->ubi_codigo = $ubi_codigo;
        $ubigeo->ubi_ubigeo = $ubi_ubigeo;
        $ubigeo->ubi_descripcion = $ubi_descripcion;
        $ubigeo->tipo_ubigeo_id = $tipo_ubigeo_id;
        
        $status = $ubigeo->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $ubigeo, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-ubigeos');;
    
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

      $ubigeo = Ubigeo::find( $id ) ;

      if (!empty($ubigeo))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $ubigeo->ubi_estado = $estado;
          $ubigeo->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $ubigeo, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $ubigeo->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $ubigeo, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $ubigeo;
        
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

      $data = Ubigeo::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}