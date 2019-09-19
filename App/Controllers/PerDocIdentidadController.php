<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\PerDocIdentidad; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PerDocIdentidadController
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

      $data = PerDocIdentidad::get();

      return view($this->prefixView.'.per-doc-identidads.list-per-doc-identidads')->with(compact('data'));
    
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

      return view($this->prefixView.'.per-doc-identidads.new-per-doc-identidad');
    
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
      $tipo_per_doc_identidad_id = $request->input('tipo_per_doc_identidad_id');
      $pdi_jerarquia = $request->input('pdi_jerarquia');
      $pdi_numero = $request->input('pdi_numero');
      $pdi_fecha_emision = $request->input('pdi_fecha_emision');
      $pdi_fecha_caducidad = $request->input('pdi_fecha_caducidad');
      $pdi_imagen = $request->file('pdi_imagen');
      $pdi_estado = !empty($request->input('pdi_estado')) ? $request->input('pdi_estado') : 1;

      $per_doc_identidad = PerDocIdentidad::where(["persona_id" => $persona_id])->first();

      if (empty($per_doc_identidad))
      {

        ##################################################################################
        $path_relative = "images/per_doc_identidads/" ;
        $name_file     = "pdi_imagen";
        $image_url     = UploadFiles::uploadFile($request, $name_file , $path_relative);
        $pdi_imagen    = $image_url ;
        ##################################################################################

        $per_doc_identidad = new PerDocIdentidad();
        $per_doc_identidad->persona_id = $persona_id;
        $per_doc_identidad->tipo_per_doc_identidad_id = $tipo_per_doc_identidad_id;
        $per_doc_identidad->pdi_jerarquia = $pdi_jerarquia;
        $per_doc_identidad->pdi_numero = $pdi_numero;
        $per_doc_identidad->pdi_fecha_emision = $pdi_fecha_emision;
        $per_doc_identidad->pdi_fecha_caducidad = $pdi_fecha_caducidad;
        $per_doc_identidad->pdi_imagen = $pdi_imagen;
        $per_doc_identidad->pdi_estado = $pdi_estado;
        
        $status = $per_doc_identidad->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $per_doc_identidad, "created") ;
        
        $id = $per_doc_identidad->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$per_doc_identidad],];
    
      return redirect()->route('admin-per-doc-identidads');
    
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

      $per_doc_identidad = PerDocIdentidad::find( $id );

      return view($this->prefixView.'.per-doc-identidads.edit-per-doc-identidad')->with(compact('per_doc_identidad'));
    
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
      $tipo_per_doc_identidad_id = $request->input('tipo_per_doc_identidad_id');
      $pdi_jerarquia = $request->input('pdi_jerarquia');
      $pdi_numero = $request->input('pdi_numero');
      $pdi_fecha_emision = $request->input('pdi_fecha_emision');
      $pdi_fecha_caducidad = $request->input('pdi_fecha_caducidad');
      $pdi_imagen = $request->file('pdi_imagen');
      $img_bd     = $request->input('img_bd');

      if (!empty($id))
      {
        ##################################################################################
        $path_relative = "images/per_doc_identidads/" ;
        $name_file     = "pdi_imagen";
        $image_url     = UploadFiles::uploadFile($request, $name_file , $path_relative);
        
        if(empty($image_url))
        {
          $image_url = $img_bd ;
        }
        
        $pdi_imagen    = $image_url ;
        ##################################################################################

        $per_doc_identidad = PerDocIdentidad::find($id);
        $per_doc_identidad->id = $id;
        $per_doc_identidad->persona_id = $persona_id;
        $per_doc_identidad->tipo_per_doc_identidad_id = $tipo_per_doc_identidad_id;
        $per_doc_identidad->pdi_jerarquia = $pdi_jerarquia;
        $per_doc_identidad->pdi_numero = $pdi_numero;
        $per_doc_identidad->pdi_fecha_emision = $pdi_fecha_emision;
        $per_doc_identidad->pdi_fecha_caducidad = $pdi_fecha_caducidad;
        $per_doc_identidad->pdi_imagen = $pdi_imagen;
        
        $status = $per_doc_identidad->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $per_doc_identidad, "update") ;
        
        # remove imagen
        if($pdi_imagen != $img_bd && $status )
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
    
      return redirect()->route('admin-per-doc-identidads');;
    
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

      $per_doc_identidad = PerDocIdentidad::find( $id ) ;

      if (!empty($per_doc_identidad))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $per_doc_identidad->pdi_estado = $estado;
          $per_doc_identidad->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $per_doc_identidad, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $per_doc_identidad->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $per_doc_identidad, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $per_doc_identidad;
        
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

      $data = PerDocIdentidad::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}