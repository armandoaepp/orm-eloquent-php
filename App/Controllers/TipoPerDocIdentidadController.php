<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\TipoPerDocIdentidad; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class TipoPerDocIdentidadController
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

      $data = TipoPerDocIdentidad::get();

      return view($this->prefixView.'.tipo-per-doc-identidads.list-tipo-per-doc-identidads')->with(compact('data'));
    
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

      return view($this->prefixView.'.tipo-per-doc-identidads.new-tipo-per-doc-identidad');
    
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

      $tpdi_descripcion = $request->input('tpdi_descripcion');
      $tpdi_glosa = $request->input('tpdi_glosa');
      $tpdi_estado = !empty($request->input('tpdi_estado')) ? $request->input('tpdi_estado') : 1;

      $tipo_per_doc_identidad = TipoPerDocIdentidad::where(["tpdi_descripcion" => $tpdi_descripcion])->first();

      if (empty($tipo_per_doc_identidad))
      {

        $tipo_per_doc_identidad = new TipoPerDocIdentidad();
        $tipo_per_doc_identidad->tpdi_descripcion = $tpdi_descripcion;
        $tipo_per_doc_identidad->tpdi_glosa = $tpdi_glosa;
        $tipo_per_doc_identidad->tpdi_estado = $tpdi_estado;
        
        $status = $tipo_per_doc_identidad->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_per_doc_identidad, "created") ;
        
        $id = $tipo_per_doc_identidad->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$tipo_per_doc_identidad],];
    
      return redirect()->route('admin-tipo-per-doc-identidads');
    
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

      $tipo_per_doc_identidad = TipoPerDocIdentidad::find( $id );

      return view($this->prefixView.'.tipo-per-doc-identidads.edit-tipo-per-doc-identidad')->with(compact('tipo_per_doc_identidad'));
    
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
      $tpdi_descripcion = $request->input('tpdi_descripcion');
      $tpdi_glosa = $request->input('tpdi_glosa');

      if (!empty($id))
      {
        $tipo_per_doc_identidad = TipoPerDocIdentidad::find($id);
        $tipo_per_doc_identidad->id = $id;
        $tipo_per_doc_identidad->tpdi_descripcion = $tpdi_descripcion;
        $tipo_per_doc_identidad->tpdi_glosa = $tpdi_glosa;
        
        $status = $tipo_per_doc_identidad->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_per_doc_identidad, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-tipo-per-doc-identidads');;
    
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

      $tipo_per_doc_identidad = TipoPerDocIdentidad::find( $id ) ;

      if (!empty($tipo_per_doc_identidad))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $tipo_per_doc_identidad->tpdi_estado = $estado;
          $tipo_per_doc_identidad->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $tipo_per_doc_identidad, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $tipo_per_doc_identidad->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $tipo_per_doc_identidad, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $tipo_per_doc_identidad;
        
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

      $data = TipoPerDocIdentidad::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}