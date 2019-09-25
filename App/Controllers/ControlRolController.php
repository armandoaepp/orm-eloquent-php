<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\ControlRol; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class ControlRolController
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

      $data = ControlRol::get();

      return view($this->prefixView.'.control-rols.list-control-rols')->with(compact('data'));
    
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

      return view($this->prefixView.'.control-rols.new-control-rol');
    
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

      $rol_id = $request->input('rol_id');
      $control_id = $request->input('control_id');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      $control_rol = ControlRol::where(["rol_id" => $rol_id])->first();

      if (empty($control_rol))
      {

        $control_rol = new ControlRol();
        $control_rol->rol_id = $rol_id;
        $control_rol->control_id = $control_id;
        $control_rol->estado = $estado;
        
        $status = $control_rol->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $control_rol, "created") ;
        
        $id = $control_rol->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$control_rol],];
    
      return redirect()->route('admin-control-rols');
    
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

      $control_rol = ControlRol::find( $id );

      return view($this->prefixView.'.control-rols.edit-control-rol')->with(compact('control_rol'));
    
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
      $rol_id = $request->input('rol_id');
      $control_id = $request->input('control_id');

      if (!empty($id))
      {
        $control_rol = ControlRol::find($id);
        $control_rol->id = $id;
        $control_rol->rol_id = $rol_id;
        $control_rol->control_id = $control_id;
        
        $status = $control_rol->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $control_rol, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-control-rols');;
    
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

      $control_rol = ControlRol::find( $id ) ;

      if (!empty($control_rol))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $control_rol->estado = $estado;
          $control_rol->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $control_rol, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $control_rol->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $control_rol, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $control_rol;
        
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

      $data = ControlRol::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}