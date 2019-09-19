<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\TipoRelacion; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class TipoRelacionController
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

      $data = TipoRelacion::get();

      return view($this->prefixView.'.tipo-relacions.list-tipo-relacions')->with(compact('data'));
    
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

      return view($this->prefixView.'.tipo-relacions.new-tipo-relacion');
    
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

      $tr_descripcion = $request->input('tr_descripcion');
      $tr_glosa = $request->input('tr_glosa');
      $tr_estado = !empty($request->input('tr_estado')) ? $request->input('tr_estado') : 1;

      $tipo_relacion = TipoRelacion::where(["tr_descripcion" => $tr_descripcion])->first();

      if (empty($tipo_relacion))
      {

        $tipo_relacion = new TipoRelacion();
        $tipo_relacion->tr_descripcion = $tr_descripcion;
        $tipo_relacion->tr_glosa = $tr_glosa;
        $tipo_relacion->tr_estado = $tr_estado;
        
        $status = $tipo_relacion->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_relacion, "created") ;
        
        $id = $tipo_relacion->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$tipo_relacion],];
    
      return redirect()->route('admin-tipo-relacions');
    
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

      $tipo_relacion = TipoRelacion::find( $id );

      return view($this->prefixView.'.tipo-relacions.edit-tipo-relacion')->with(compact('tipo_relacion'));
    
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
      $tr_descripcion = $request->input('tr_descripcion');
      $tr_glosa = $request->input('tr_glosa');

      if (!empty($id))
      {
        $tipo_relacion = TipoRelacion::find($id);
        $tipo_relacion->id = $id;
        $tipo_relacion->tr_descripcion = $tr_descripcion;
        $tipo_relacion->tr_glosa = $tr_glosa;
        
        $status = $tipo_relacion->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_relacion, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-tipo-relacions');;
    
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

      $tipo_relacion = TipoRelacion::find( $id ) ;

      if (!empty($tipo_relacion))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $tipo_relacion->tr_estado = $estado;
          $tipo_relacion->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $tipo_relacion, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $tipo_relacion->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $tipo_relacion, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $tipo_relacion;
        
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

      $data = TipoRelacion::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}