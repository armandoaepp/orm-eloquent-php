<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\TipoPerDocumento; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class TipoPerDocumentoController
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

      $data = TipoPerDocumento::get();

      return view($this->prefixView.'.tipo-per-documentos.list-tipo-per-documentos')->with(compact('data'));
    
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

      return view($this->prefixView.'.tipo-per-documentos.new-tipo-per-documento');
    
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

      $tpd_descripcion = $request->input('tpd_descripcion');
      $tpd_estado = !empty($request->input('tpd_estado')) ? $request->input('tpd_estado') : 1;

      $tipo_per_documento = TipoPerDocumento::where(["tpd_descripcion" => $tpd_descripcion])->first();

      if (empty($tipo_per_documento))
      {

        $tipo_per_documento = new TipoPerDocumento();
        $tipo_per_documento->tpd_descripcion = $tpd_descripcion;
        $tipo_per_documento->tpd_estado = $tpd_estado;
        
        $status = $tipo_per_documento->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_per_documento, "created") ;
        
        $id = $tipo_per_documento->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$tipo_per_documento],];
    
      return redirect()->route('admin-tipo-per-documentos');
    
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

      $tipo_per_documento = TipoPerDocumento::find( $id );

      return view($this->prefixView.'.tipo-per-documentos.edit-tipo-per-documento')->with(compact('tipo_per_documento'));
    
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
      $tpd_descripcion = $request->input('tpd_descripcion');

      if (!empty($id))
      {
        $tipo_per_documento = TipoPerDocumento::find($id);
        $tipo_per_documento->id = $id;
        $tipo_per_documento->tpd_descripcion = $tpd_descripcion;
        
        $status = $tipo_per_documento->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_per_documento, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-tipo-per-documentos');;
    
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

      $tipo_per_documento = TipoPerDocumento::find( $id ) ;

      if (!empty($tipo_per_documento))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $tipo_per_documento->tpd_estado = $estado;
          $tipo_per_documento->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $tipo_per_documento, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $tipo_per_documento->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $tipo_per_documento, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $tipo_per_documento;
        
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

      $data = TipoPerDocumento::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}