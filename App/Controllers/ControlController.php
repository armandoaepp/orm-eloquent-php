<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Control; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class ControlController
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

      $data = Control::get();

      return view($this->prefixView.'.controls.list-controls')->with(compact('data'));
    
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

      return view($this->prefixView.'.controls.new-control');
    
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

      $control_padre_id = $request->input('control_padre_id');
      $tipo_control_id = $request->input('tipo_control_id');
      $jerarquia = $request->input('jerarquia');
      $nombre = $request->input('nombre');
      $valor = $request->input('valor');
      $descripcion = $request->input('descripcion');
      $glosa = $request->input('glosa');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      $control = Control::where(["control_padre_id" => $control_padre_id])->first();

      if (empty($control))
      {

        $control = new Control();
        $control->control_padre_id = $control_padre_id;
        $control->tipo_control_id = $tipo_control_id;
        $control->jerarquia = $jerarquia;
        $control->nombre = $nombre;
        $control->valor = $valor;
        $control->descripcion = $descripcion;
        $control->glosa = $glosa;
        $control->estado = $estado;
        
        $status = $control->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $control, "created") ;
        
        $id = $control->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$control],];
    
      return redirect()->route('admin-controls');
    
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

      $control = Control::find( $id );

      return view($this->prefixView.'.controls.edit-control')->with(compact('control'));
    
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
      $control_padre_id = $request->input('control_padre_id');
      $tipo_control_id = $request->input('tipo_control_id');
      $jerarquia = $request->input('jerarquia');
      $nombre = $request->input('nombre');
      $valor = $request->input('valor');
      $descripcion = $request->input('descripcion');
      $glosa = $request->input('glosa');

      if (!empty($id))
      {
        $control = Control::find($id);
        $control->id = $id;
        $control->control_padre_id = $control_padre_id;
        $control->tipo_control_id = $tipo_control_id;
        $control->jerarquia = $jerarquia;
        $control->nombre = $nombre;
        $control->valor = $valor;
        $control->descripcion = $descripcion;
        $control->glosa = $glosa;
        
        $status = $control->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $control, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-controls');;
    
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

      $control = Control::find( $id ) ;

      if (!empty($control))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $control->estado = $estado;
          $control->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $control, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $control->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $control, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $control;
        
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

      $data = Control::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}