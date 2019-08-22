<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\TipoMedia; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class TipoMediaController
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

      $data = TipoMedia::get();

      return view($this->prefixView.'.tipo-media.list-tipo-media')->with(compact('data'));
    
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

      return view($this->prefixView.'.tipo-media.new-tipo-media');
    
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

      $tm_descripcion = $request->input('tm_descripcion');
      $tm_estado = !empty($request->input('tm_estado')) ? $request->input('tm_estado') : 1;

      $tipo_media = TipoMedia::where(["tm_descripcion" => $tm_descripcion])->first();

      if (empty($tipo_media))
      {

        $tipo_media = new TipoMedia();
        $tipo_media->tm_descripcion = $tm_descripcion;
        $tipo_media->tm_estado = $tm_estado;
        
        $status = $tipo_media->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_media, "created") ;
        
        $id = $tipo_media->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$tipo_media],];
    
      return redirect()->route('admin-tipo-media');
    
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

      $tipo_media = TipoMedia::find( $id );

      return view($this->prefixView.'.tipo-media.edit-tipo-media')->with(compact('tipo_media'));
    
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
      $tm_descripcion = $request->input('tm_descripcion');

      if (!empty($id))
      {
        $tipo_media = TipoMedia::find($id);
        $tipo_media->id = $id;
        $tipo_media->tm_descripcion = $tm_descripcion;
        
        $status = $tipo_media->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_media, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-tipo-media');;
    
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

      $tipo_media = TipoMedia::find( $id ) ;

      if (!empty($tipo_media))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $tipo_media->tm_estado = $estado;
          $tipo_media->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $tipo_media, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $tipo_media->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $tipo_media, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $tipo_media;
        
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

      $data = TipoMedia::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}