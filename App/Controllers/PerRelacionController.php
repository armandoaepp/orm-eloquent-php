<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\PerRelacion; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PerRelacionController
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

      $data = PerRelacion::get();

      return view($this->prefixView.'.per-relacions.list-per-relacions')->with(compact('data'));
    
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

      return view($this->prefixView.'.per-relacions.new-per-relacion');
    
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
      $tipo_relacion_id = $request->input('tipo_relacion_id');
      $referencia = $request->input('referencia');
      $pr_estado = !empty($request->input('pr_estado')) ? $request->input('pr_estado') : 1;

      $per_relacion = PerRelacion::where(["persona_id" => $persona_id])->first();

      if (empty($per_relacion))
      {

        $per_relacion = new PerRelacion();
        $per_relacion->persona_id = $persona_id;
        $per_relacion->tipo_relacion_id = $tipo_relacion_id;
        $per_relacion->referencia = $referencia;
        $per_relacion->pr_estado = $pr_estado;
        
        $status = $per_relacion->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $per_relacion, "created") ;
        
        $id = $per_relacion->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$per_relacion],];
    
      return redirect()->route('admin-per-relacions');
    
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

      $per_relacion = PerRelacion::find( $id );

      return view($this->prefixView.'.per-relacions.edit-per-relacion')->with(compact('per_relacion'));
    
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
      $tipo_relacion_id = $request->input('tipo_relacion_id');
      $referencia = $request->input('referencia');

      if (!empty($id))
      {
        $per_relacion = PerRelacion::find($id);
        $per_relacion->id = $id;
        $per_relacion->persona_id = $persona_id;
        $per_relacion->tipo_relacion_id = $tipo_relacion_id;
        $per_relacion->referencia = $referencia;
        
        $status = $per_relacion->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $per_relacion, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-per-relacions');;
    
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

      $per_relacion = PerRelacion::find( $id ) ;

      if (!empty($per_relacion))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $per_relacion->pr_estado = $estado;
          $per_relacion->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $per_relacion, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $per_relacion->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $per_relacion, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $per_relacion;
        
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

      $data = PerRelacion::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}