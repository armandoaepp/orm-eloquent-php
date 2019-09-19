<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\PerNatural; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PerNaturalController
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

      $data = PerNatural::get();

      return view($this->prefixView.'.per-naturals.list-per-naturals')->with(compact('data'));
    
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

      return view($this->prefixView.'.per-naturals.new-per-natural');
    
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
      $pn_dni = $request->input('pn_dni');
      $pn_ruc = $request->input('pn_ruc');
      $pn_apellidos = $request->input('pn_apellidos');
      $pn_nombres = $request->input('pn_nombres');
      $sexo_id = $request->input('sexo_id');
      $estado_civil_id = $request->input('estado_civil_id');
      $pn_estado = !empty($request->input('pn_estado')) ? $request->input('pn_estado') : 1;

      $per_natural = PerNatural::where(["persona_id" => $persona_id])->first();

      if (empty($per_natural))
      {

        $per_natural = new PerNatural();
        $per_natural->persona_id = $persona_id;
        $per_natural->pn_dni = $pn_dni;
        $per_natural->pn_ruc = $pn_ruc;
        $per_natural->pn_apellidos = $pn_apellidos;
        $per_natural->pn_nombres = $pn_nombres;
        $per_natural->sexo_id = $sexo_id;
        $per_natural->estado_civil_id = $estado_civil_id;
        $per_natural->pn_estado = $pn_estado;
        
        $status = $per_natural->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $per_natural, "created") ;
        
        $id = $per_natural->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$per_natural],];
    
      return redirect()->route('admin-per-naturals');
    
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

      $per_natural = PerNatural::find( $id );

      return view($this->prefixView.'.per-naturals.edit-per-natural')->with(compact('per_natural'));
    
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
      $pn_dni = $request->input('pn_dni');
      $pn_ruc = $request->input('pn_ruc');
      $pn_apellidos = $request->input('pn_apellidos');
      $pn_nombres = $request->input('pn_nombres');
      $sexo_id = $request->input('sexo_id');
      $estado_civil_id = $request->input('estado_civil_id');

      if (!empty($id))
      {
        $per_natural = PerNatural::find($id);
        $per_natural->id = $id;
        $per_natural->persona_id = $persona_id;
        $per_natural->pn_dni = $pn_dni;
        $per_natural->pn_ruc = $pn_ruc;
        $per_natural->pn_apellidos = $pn_apellidos;
        $per_natural->pn_nombres = $pn_nombres;
        $per_natural->sexo_id = $sexo_id;
        $per_natural->estado_civil_id = $estado_civil_id;
        
        $status = $per_natural->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $per_natural, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-per-naturals');;
    
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

      $per_natural = PerNatural::find( $id ) ;

      if (!empty($per_natural))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $per_natural->pn_estado = $estado;
          $per_natural->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $per_natural, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $per_natural->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $per_natural, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $per_natural;
        
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

      $data = PerNatural::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}