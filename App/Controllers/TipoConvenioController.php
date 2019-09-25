<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\TipoConvenio; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class TipoConvenioController
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

      $data = TipoConvenio::get();

      return view($this->prefixView.'.tipo-convenios.list-tipo-convenios')->with(compact('data'));
    
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

      return view($this->prefixView.'.tipo-convenios.new-tipo-convenio');
    
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

      $tc_descripcion = $request->input('tc_descripcion');
      $tc_estado = !empty($request->input('tc_estado')) ? $request->input('tc_estado') : 1;

      $tipo_convenio = TipoConvenio::where(["tc_descripcion" => $tc_descripcion])->first();

      if (empty($tipo_convenio))
      {

        $tipo_convenio = new TipoConvenio();
        $tipo_convenio->tc_descripcion = $tc_descripcion;
        $tipo_convenio->tc_estado = $tc_estado;
        
        $status = $tipo_convenio->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_convenio, "created") ;
        
        $id = $tipo_convenio->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$tipo_convenio],];
    
      return redirect()->route('admin-tipo-convenios');
    
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

      $tipo_convenio = TipoConvenio::find( $id );

      return view($this->prefixView.'.tipo-convenios.edit-tipo-convenio')->with(compact('tipo_convenio'));
    
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
      $tc_descripcion = $request->input('tc_descripcion');

      if (!empty($id))
      {
        $tipo_convenio = TipoConvenio::find($id);
        $tipo_convenio->id = $id;
        $tipo_convenio->tc_descripcion = $tc_descripcion;
        
        $status = $tipo_convenio->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_convenio, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-tipo-convenios');;
    
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

      $tipo_convenio = TipoConvenio::find( $id ) ;

      if (!empty($tipo_convenio))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $tipo_convenio->tc_estado = $estado;
          $tipo_convenio->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $tipo_convenio, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $tipo_convenio->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $tipo_convenio, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $tipo_convenio;
        
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

      $data = TipoConvenio::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}