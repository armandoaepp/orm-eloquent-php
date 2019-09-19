<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\PerDocumento; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PerDocumentoController
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

      $data = PerDocumento::get();

      return view($this->prefixView.'.per-documentos.list-per-documentos')->with(compact('data'));
    
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

      return view($this->prefixView.'.per-documentos.new-per-documento');
    
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

      $persona_id = $request->input('persona_id');
      $tipo_per_documento_id = $request->input('tipo_per_documento_id');
      $pd_numero = $request->input('pd_numero');
      $pd_fecha_emision = $request->input('pd_fecha_emision');
      $pd_echa_caducidad = $request->input('pd_echa_caducidad');
      $pd_descripcion = $request->input('pd_descripcion');
      $pd_imagen = $request->file('pd_imagen');
      $pd_estado = !empty($request->input('pd_estado')) ? $request->input('pd_estado') : 1;

      $per_documento = PerDocumento::where(["persona_id" => $persona_id])->first();

      if (empty($per_documento))
      {

        ##################################################################################
        $path_relative = "images/per_documentos/" ;
        $name_file     = "pd_imagen";
        $image_url     = UploadFiles::uploadFile($request, $name_file , $path_relative);
        $pd_imagen    = $image_url ;
        ##################################################################################

        $per_documento = new PerDocumento();
        $per_documento->persona_id = $persona_id;
        $per_documento->tipo_per_documento_id = $tipo_per_documento_id;
        $per_documento->pd_numero = $pd_numero;
        $per_documento->pd_fecha_emision = $pd_fecha_emision;
        $per_documento->pd_echa_caducidad = $pd_echa_caducidad;
        $per_documento->pd_descripcion = $pd_descripcion;
        $per_documento->pd_imagen = $pd_imagen;
        $per_documento->pd_estado = $pd_estado;
        
        $status = $per_documento->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $per_documento, "created") ;
        
        $id = $per_documento->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$per_documento],];
    
      return redirect()->route('admin-per-documentos');
    
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

      $per_documento = PerDocumento::find( $id );

      return view($this->prefixView.'.per-documentos.edit-per-documento')->with(compact('per_documento'));
    
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
      $persona_id = $request->input('persona_id');
      $tipo_per_documento_id = $request->input('tipo_per_documento_id');
      $pd_numero = $request->input('pd_numero');
      $pd_fecha_emision = $request->input('pd_fecha_emision');
      $pd_echa_caducidad = $request->input('pd_echa_caducidad');
      $pd_descripcion = $request->input('pd_descripcion');
      $pd_imagen = $request->file('pd_imagen');
      $img_bd     = $request->input('img_bd');

      if (!empty($id))
      {
        ##################################################################################
        $path_relative = "images/per_documentos/" ;
        $name_file     = "pd_imagen";
        $image_url     = UploadFiles::uploadFile($request, $name_file , $path_relative);
        
        if(empty($image_url))
        {
          $image_url = $img_bd ;
        }
        
        $pd_imagen    = $image_url ;
        ##################################################################################

        $per_documento = PerDocumento::find($id);
        $per_documento->id = $id;
        $per_documento->persona_id = $persona_id;
        $per_documento->tipo_per_documento_id = $tipo_per_documento_id;
        $per_documento->pd_numero = $pd_numero;
        $per_documento->pd_fecha_emision = $pd_fecha_emision;
        $per_documento->pd_echa_caducidad = $pd_echa_caducidad;
        $per_documento->pd_descripcion = $pd_descripcion;
        $per_documento->pd_imagen = $pd_imagen;
        
        $status = $per_documento->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $per_documento, "update") ;
        
        # remove imagen
        if($pd_imagen != $img_bd && $status )
        {
          if (file_exists($img_bd))
            unlink($img_bd) ;
        }
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-per-documentos');;
    
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

      $per_documento = PerDocumento::find( $id ) ;

      if (!empty($per_documento))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $per_documento->pd_estado = $estado;
          $per_documento->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $per_documento, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $per_documento->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $per_documento, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $per_documento;
        
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

      $data = PerDocumento::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}