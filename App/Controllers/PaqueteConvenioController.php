<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\PaqueteConvenio; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PaqueteConvenioController
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

      $data = PaqueteConvenio::get();

      return view($this->prefixView.'.paquete-convenios.list-paquete-convenios')->with(compact('data'));
    
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

      return view($this->prefixView.'.paquete-convenios.new-paquete-convenio');
    
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

      $paquete_id = $request->input('paquete_id');
      $convenio_id = $request->input('convenio_id');
      $pc_estado = !empty($request->input('pc_estado')) ? $request->input('pc_estado') : 1;

      $paquete_convenio = PaqueteConvenio::where(["paquete_id" => $paquete_id])->first();

      if (empty($paquete_convenio))
      {

        $paquete_convenio = new PaqueteConvenio();
        $paquete_convenio->paquete_id = $paquete_id;
        $paquete_convenio->convenio_id = $convenio_id;
        $paquete_convenio->pc_estado = $pc_estado;
        
        $status = $paquete_convenio->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $paquete_convenio, "created") ;
        
        $id = $paquete_convenio->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$paquete_convenio],];
    
      return redirect()->route('admin-paquete-convenios');
    
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

      $paquete_convenio = PaqueteConvenio::find( $id );

      return view($this->prefixView.'.paquete-convenios.edit-paquete-convenio')->with(compact('paquete_convenio'));
    
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
      $paquete_id = $request->input('paquete_id');
      $convenio_id = $request->input('convenio_id');

      if (!empty($id))
      {
        $paquete_convenio = PaqueteConvenio::find($id);
        $paquete_convenio->id = $id;
        $paquete_convenio->paquete_id = $paquete_id;
        $paquete_convenio->convenio_id = $convenio_id;
        
        $status = $paquete_convenio->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $paquete_convenio, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-paquete-convenios');;
    
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

      $paquete_convenio = PaqueteConvenio::find( $id ) ;

      if (!empty($paquete_convenio))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $paquete_convenio->pc_estado = $estado;
          $paquete_convenio->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $paquete_convenio, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $paquete_convenio->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $paquete_convenio, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $paquete_convenio;
        
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

      $data = PaqueteConvenio::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}