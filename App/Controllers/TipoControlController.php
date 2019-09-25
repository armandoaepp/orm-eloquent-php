<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\TipoControl; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class TipoControlController
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

      $data = TipoControl::get();

      return view($this->prefixView.'.tipo-controls.list-tipo-controls')->with(compact('data'));
    
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

      return view($this->prefixView.'.tipo-controls.new-tipo-control');
    
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

      $descripcion = $request->input('descripcion');
      $glosa = $request->input('glosa');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      $tipo_control = TipoControl::where(["descripcion" => $descripcion])->first();

      if (empty($tipo_control))
      {

        $tipo_control = new TipoControl();
        $tipo_control->descripcion = $descripcion;
        $tipo_control->glosa = $glosa;
        $tipo_control->estado = $estado;
        
        $status = $tipo_control->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_control, "created") ;
        
        $id = $tipo_control->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$tipo_control],];
    
      return redirect()->route('admin-tipo-controls');
    
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

      $tipo_control = TipoControl::find( $id );

      return view($this->prefixView.'.tipo-controls.edit-tipo-control')->with(compact('tipo_control'));
    
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
      $descripcion = $request->input('descripcion');
      $glosa = $request->input('glosa');

      if (!empty($id))
      {
        $tipo_control = TipoControl::find($id);
        $tipo_control->id = $id;
        $tipo_control->descripcion = $descripcion;
        $tipo_control->glosa = $glosa;
        
        $status = $tipo_control->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_control, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-tipo-controls');;
    
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

      $tipo_control = TipoControl::find( $id ) ;

      if (!empty($tipo_control))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $tipo_control->estado = $estado;
          $tipo_control->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $tipo_control, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $tipo_control->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $tipo_control, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $tipo_control;
        
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

      $data = TipoControl::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}