<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Rol; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class RolController
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

      $data = Rol::get();

      return view($this->prefixView.'.rols.list-rols')->with(compact('data'));
    
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

      return view($this->prefixView.'.rols.new-rol');
    
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
      $nombre = $request->input('nombre');
      $descripcion = $request->input('descripcion');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      $rol = Rol::where(["per_id_padre" => $per_id_padre])->first();

      if (empty($rol))
      {

        $rol = new Rol();
        $rol->per_id_padre = $per_id_padre;
        $rol->nombre = $nombre;
        $rol->descripcion = $descripcion;
        $rol->estado = $estado;
        
        $status = $rol->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $rol, "created") ;
        
        $id = $rol->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$rol],];
    
      return redirect()->route('admin-rols');
    
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

      $rol = Rol::find( $id );

      return view($this->prefixView.'.rols.edit-rol')->with(compact('rol'));
    
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
      $nombre = $request->input('nombre');
      $descripcion = $request->input('descripcion');

      if (!empty($id))
      {
        $rol = Rol::find($id);
        $rol->id = $id;
        $rol->per_id_padre = $per_id_padre;
        $rol->nombre = $nombre;
        $rol->descripcion = $descripcion;
        
        $status = $rol->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $rol, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-rols');;
    
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

      $rol = Rol::find( $id ) ;

      if (!empty($rol))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $rol->estado = $estado;
          $rol->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $rol, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $rol->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $rol, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $rol;
        
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

      $data = Rol::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}