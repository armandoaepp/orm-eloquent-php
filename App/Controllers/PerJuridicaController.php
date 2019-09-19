<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\PerJuridica; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PerJuridicaController
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

      $data = PerJuridica::get();

      return view($this->prefixView.'.per-juridicas.list-per-juridicas')->with(compact('data'));
    
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

      return view($this->prefixView.'.per-juridicas.new-per-juridica');
    
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
      $rubro_id = $request->input('rubro_id');
      $pj_ruc = $request->input('pj_ruc');
      $pj_razon_social = $request->input('pj_razon_social');
      $pj_nombre_comercial = $request->input('pj_nombre_comercial');
      $pj_glosa = $request->input('pj_glosa');
      $pj_estado = !empty($request->input('pj_estado')) ? $request->input('pj_estado') : 1;

      $per_juridica = PerJuridica::where(["persona_id" => $persona_id])->first();

      if (empty($per_juridica))
      {

        $per_juridica = new PerJuridica();
        $per_juridica->persona_id = $persona_id;
        $per_juridica->rubro_id = $rubro_id;
        $per_juridica->pj_ruc = $pj_ruc;
        $per_juridica->pj_razon_social = $pj_razon_social;
        $per_juridica->pj_nombre_comercial = $pj_nombre_comercial;
        $per_juridica->pj_glosa = $pj_glosa;
        $per_juridica->pj_estado = $pj_estado;
        
        $status = $per_juridica->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $per_juridica, "created") ;
        
        $id = $per_juridica->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$per_juridica],];
    
      return redirect()->route('admin-per-juridicas');
    
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

      $per_juridica = PerJuridica::find( $id );

      return view($this->prefixView.'.per-juridicas.edit-per-juridica')->with(compact('per_juridica'));
    
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
      $rubro_id = $request->input('rubro_id');
      $pj_ruc = $request->input('pj_ruc');
      $pj_razon_social = $request->input('pj_razon_social');
      $pj_nombre_comercial = $request->input('pj_nombre_comercial');
      $pj_glosa = $request->input('pj_glosa');

      if (!empty($id))
      {
        $per_juridica = PerJuridica::find($id);
        $per_juridica->id = $id;
        $per_juridica->persona_id = $persona_id;
        $per_juridica->rubro_id = $rubro_id;
        $per_juridica->pj_ruc = $pj_ruc;
        $per_juridica->pj_razon_social = $pj_razon_social;
        $per_juridica->pj_nombre_comercial = $pj_nombre_comercial;
        $per_juridica->pj_glosa = $pj_glosa;
        
        $status = $per_juridica->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $per_juridica, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-per-juridicas');;
    
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

      $per_juridica = PerJuridica::find( $id ) ;

      if (!empty($per_juridica))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $per_juridica->pj_estado = $estado;
          $per_juridica->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $per_juridica, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $per_juridica->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $per_juridica, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $per_juridica;
        
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

      $data = PerJuridica::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}