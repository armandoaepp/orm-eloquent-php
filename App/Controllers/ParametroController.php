<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Parametro; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class ParametroController
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

      $data = Parametro::get();

      return view($this->prefixView.'.parametros.list-parametros')->with(compact('data'));
    
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

      return view($this->prefixView.'.parametros.new-parametro');
    
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
      $par_jerarquia = $request->input('par_jerarquia');
      $par_nombre = $request->input('par_nombre');
      $par_estado = !empty($request->input('par_estado')) ? $request->input('par_estado') : 1;

      $parametro = Parametro::where(["per_id_padre" => $per_id_padre])->first();

      if (empty($parametro))
      {

        $parametro = new Parametro();
        $parametro->per_id_padre = $per_id_padre;
        $parametro->par_jerarquia = $par_jerarquia;
        $parametro->par_nombre = $par_nombre;
        $parametro->par_estado = $par_estado;
        
        $status = $parametro->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $parametro, "created") ;
        
        $id = $parametro->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$parametro],];
    
      return redirect()->route('admin-parametros');
    
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

      $parametro = Parametro::find( $id );

      return view($this->prefixView.'.parametros.edit-parametro')->with(compact('parametro'));
    
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
      $par_jerarquia = $request->input('par_jerarquia');
      $par_nombre = $request->input('par_nombre');

      if (!empty($id))
      {
        $parametro = Parametro::find($id);
        $parametro->id = $id;
        $parametro->per_id_padre = $per_id_padre;
        $parametro->par_jerarquia = $par_jerarquia;
        $parametro->par_nombre = $par_nombre;
        
        $status = $parametro->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $parametro, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-parametros');;
    
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

      $parametro = Parametro::find( $id ) ;

      if (!empty($parametro))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $parametro->par_estado = $estado;
          $parametro->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $parametro, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $parametro->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $parametro, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $parametro;
        
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

      $data = Parametro::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}