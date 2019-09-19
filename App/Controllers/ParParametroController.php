<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\ParParametro; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class ParParametroController
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

      $data = ParParametro::get();

      return view($this->prefixView.'.par-parametros.list-par-parametros')->with(compact('data'));
    
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

      return view($this->prefixView.'.par-parametros.new-par-parametro');
    
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

      $per_id_padre = $request->input('per_id_padre');
      $parametro_id = $request->input('parametro_id');
      $pp_codigo = $request->input('pp_codigo');
      $pp_jerarquia = $request->input('pp_jerarquia');
      $pp_nombre = $request->input('pp_nombre');
      $pp_descripcion = $request->input('pp_descripcion');
      $pp_estado = !empty($request->input('pp_estado')) ? $request->input('pp_estado') : 1;

      $par_parametro = ParParametro::where(["per_id_padre" => $per_id_padre])->first();

      if (empty($par_parametro))
      {

        $par_parametro = new ParParametro();
        $par_parametro->per_id_padre = $per_id_padre;
        $par_parametro->parametro_id = $parametro_id;
        $par_parametro->pp_codigo = $pp_codigo;
        $par_parametro->pp_jerarquia = $pp_jerarquia;
        $par_parametro->pp_nombre = $pp_nombre;
        $par_parametro->pp_descripcion = $pp_descripcion;
        $par_parametro->pp_estado = $pp_estado;
        
        $status = $par_parametro->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $par_parametro, "created") ;
        
        $id = $par_parametro->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$par_parametro],];
    
      return redirect()->route('admin-par-parametros');
    
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

      $par_parametro = ParParametro::find( $id );

      return view($this->prefixView.'.par-parametros.edit-par-parametro')->with(compact('par_parametro'));
    
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
      $per_id_padre = $request->input('per_id_padre');
      $parametro_id = $request->input('parametro_id');
      $pp_codigo = $request->input('pp_codigo');
      $pp_jerarquia = $request->input('pp_jerarquia');
      $pp_nombre = $request->input('pp_nombre');
      $pp_descripcion = $request->input('pp_descripcion');

      if (!empty($id))
      {
        $par_parametro = ParParametro::find($id);
        $par_parametro->id = $id;
        $par_parametro->per_id_padre = $per_id_padre;
        $par_parametro->parametro_id = $parametro_id;
        $par_parametro->pp_codigo = $pp_codigo;
        $par_parametro->pp_jerarquia = $pp_jerarquia;
        $par_parametro->pp_nombre = $pp_nombre;
        $par_parametro->pp_descripcion = $pp_descripcion;
        
        $status = $par_parametro->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $par_parametro, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-par-parametros');;
    
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

      $par_parametro = ParParametro::find( $id ) ;

      if (!empty($par_parametro))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $par_parametro->pp_estado = $estado;
          $par_parametro->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $par_parametro, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $par_parametro->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $par_parametro, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $par_parametro;
        
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

      $data = ParParametro::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}