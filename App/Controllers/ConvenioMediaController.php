<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\ConvenioMedia; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class ConvenioMediaController
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

      $data = ConvenioMedia::get();

      return view($this->prefixView.'.convenio-media.list-convenio-media')->with(compact('data'));
    
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

      return view($this->prefixView.'.convenio-media.new-convenio-media');
    
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

      $convenio_id = $request->input('convenio_id');
      $cm_path_file = $request->input('cm_path_file');
      $cm_jerarquia = $request->input('cm_jerarquia');
      $cm_descripcion = $request->input('cm_descripcion');
      $con_estado = $request->input('con_estado');

      $convenio_media = ConvenioMedia::where(["convenio_id" => $convenio_id])->first();

      if (empty($convenio_media))
      {

        $convenio_media = new ConvenioMedia();
        $convenio_media->convenio_id = $convenio_id;
        $convenio_media->cm_path_file = $cm_path_file;
        $convenio_media->cm_jerarquia = $cm_jerarquia;
        $convenio_media->cm_descripcion = $cm_descripcion;
        $convenio_media->con_estado = $con_estado;
        
        $status = $convenio_media->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $convenio_media, "created") ;
        
        $id = $convenio_media->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$convenio_media],];
    
      return redirect()->route('admin-convenio-media');
    
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

      $convenio_media = ConvenioMedia::find( $id );

      return view($this->prefixView.'.convenio-media.edit-convenio-media')->with(compact('convenio_media'));
    
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
      $convenio_id = $request->input('convenio_id');
      $cm_path_file = $request->input('cm_path_file');
      $cm_jerarquia = $request->input('cm_jerarquia');
      $cm_descripcion = $request->input('cm_descripcion');
      $con_estado = $request->input('con_estado');

      if (!empty($id))
      {
        $convenio_media = ConvenioMedia::find($id);
        $convenio_media->id = $id;
        $convenio_media->convenio_id = $convenio_id;
        $convenio_media->cm_path_file = $cm_path_file;
        $convenio_media->cm_jerarquia = $cm_jerarquia;
        $convenio_media->cm_descripcion = $cm_descripcion;
        $convenio_media->con_estado = $con_estado;
        
        $status = $convenio_media->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $convenio_media, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-convenio-media');;
    
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

      $convenio_media = ConvenioMedia::find( $id ) ;

      if (!empty($convenio_media))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $convenio_media->cm_estado = $estado;
          $convenio_media->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $convenio_media, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $convenio_media->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $convenio_media, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $convenio_media;
        
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

      $data = ConvenioMedia::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}