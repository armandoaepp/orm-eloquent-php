<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Permiso; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PermisoController
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

      $data = Permiso::get();

      return view($this->prefixView.'.permisos.list-permisos')->with(compact('data'));
    
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

      return view($this->prefixView.'.permisos.new-permiso');
    
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

      $user_id = $request->input('user_id');
      $control_id = $request->input('control_id');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      $permiso = Permiso::where(["user_id" => $user_id])->first();

      if (empty($permiso))
      {

        $permiso = new Permiso();
        $permiso->user_id = $user_id;
        $permiso->control_id = $control_id;
        $permiso->estado = $estado;
        
        $status = $permiso->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $permiso, "created") ;
        
        $id = $permiso->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$permiso],];
    
      return redirect()->route('admin-permisos');
    
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

      $permiso = Permiso::find( $id );

      return view($this->prefixView.'.permisos.edit-permiso')->with(compact('permiso'));
    
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
      $user_id = $request->input('user_id');
      $control_id = $request->input('control_id');

      if (!empty($id))
      {
        $permiso = Permiso::find($id);
        $permiso->id = $id;
        $permiso->user_id = $user_id;
        $permiso->control_id = $control_id;
        
        $status = $permiso->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $permiso, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-permisos');;
    
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

      $permiso = Permiso::find( $id ) ;

      if (!empty($permiso))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $permiso->estado = $estado;
          $permiso->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $permiso, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $permiso->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $permiso, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $permiso;
        
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

      $data = Permiso::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}