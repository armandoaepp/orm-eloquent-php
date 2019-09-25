<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\PaqueteMedia; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PaqueteMediaController
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

      $data = PaqueteMedia::get();

      return view($this->prefixView.'.paquete-media.list-paquete-media')->with(compact('data'));
    
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

      return view($this->prefixView.'.paquete-media.new-paquete-media');
    
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
      $tipo_media_id = $request->input('tipo_media_id');
      $pm_path_file = $request->input('pm_path_file');
      $pm_jerarquia = $request->input('pm_jerarquia');
      $pm_descripcion = $request->input('pm_descripcion');
      $pm_estado = !empty($request->input('pm_estado')) ? $request->input('pm_estado') : 1;

      $paquete_media = PaqueteMedia::where(["paquete_id" => $paquete_id])->first();

      if (empty($paquete_media))
      {

        $paquete_media = new PaqueteMedia();
        $paquete_media->paquete_id = $paquete_id;
        $paquete_media->tipo_media_id = $tipo_media_id;
        $paquete_media->pm_path_file = $pm_path_file;
        $paquete_media->pm_jerarquia = $pm_jerarquia;
        $paquete_media->pm_descripcion = $pm_descripcion;
        $paquete_media->pm_estado = $pm_estado;
        
        $status = $paquete_media->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $paquete_media, "created") ;
        
        $id = $paquete_media->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$paquete_media],];
    
      return redirect()->route('admin-paquete-media');
    
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

      $paquete_media = PaqueteMedia::find( $id );

      return view($this->prefixView.'.paquete-media.edit-paquete-media')->with(compact('paquete_media'));
    
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
      $tipo_media_id = $request->input('tipo_media_id');
      $pm_path_file = $request->input('pm_path_file');
      $pm_jerarquia = $request->input('pm_jerarquia');
      $pm_descripcion = $request->input('pm_descripcion');

      if (!empty($id))
      {
        $paquete_media = PaqueteMedia::find($id);
        $paquete_media->id = $id;
        $paquete_media->paquete_id = $paquete_id;
        $paquete_media->tipo_media_id = $tipo_media_id;
        $paquete_media->pm_path_file = $pm_path_file;
        $paquete_media->pm_jerarquia = $pm_jerarquia;
        $paquete_media->pm_descripcion = $pm_descripcion;
        
        $status = $paquete_media->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $paquete_media, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-paquete-media');;
    
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

      $paquete_media = PaqueteMedia::find( $id ) ;

      if (!empty($paquete_media))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $paquete_media->pm_estado = $estado;
          $paquete_media->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $paquete_media, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $paquete_media->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $paquete_media, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $paquete_media;
        
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

      $data = PaqueteMedia::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}