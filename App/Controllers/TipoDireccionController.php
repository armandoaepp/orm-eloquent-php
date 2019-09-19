<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\TipoDireccion; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class TipoDireccionController
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

      $data = TipoDireccion::get();

      return view($this->prefixView.'.tipo-direccions.list-tipo-direccions')->with(compact('data'));
    
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

      return view($this->prefixView.'.tipo-direccions.new-tipo-direccion');
    
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

      $td_descripcion = $request->input('td_descripcion');
      $td_estado = !empty($request->input('td_estado')) ? $request->input('td_estado') : 1;

      $tipo_direccion = TipoDireccion::where(["td_descripcion" => $td_descripcion])->first();

      if (empty($tipo_direccion))
      {

        $tipo_direccion = new TipoDireccion();
        $tipo_direccion->td_descripcion = $td_descripcion;
        $tipo_direccion->td_estado = $td_estado;
        
        $status = $tipo_direccion->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_direccion, "created") ;
        
        $id = $tipo_direccion->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$tipo_direccion],];
    
      return redirect()->route('admin-tipo-direccions');
    
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

      $tipo_direccion = TipoDireccion::find( $id );

      return view($this->prefixView.'.tipo-direccions.edit-tipo-direccion')->with(compact('tipo_direccion'));
    
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
      $td_descripcion = $request->input('td_descripcion');

      if (!empty($id))
      {
        $tipo_direccion = TipoDireccion::find($id);
        $tipo_direccion->id = $id;
        $tipo_direccion->td_descripcion = $td_descripcion;
        
        $status = $tipo_direccion->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_direccion, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-tipo-direccions');;
    
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

      $tipo_direccion = TipoDireccion::find( $id ) ;

      if (!empty($tipo_direccion))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $tipo_direccion->td_estado = $estado;
          $tipo_direccion->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $tipo_direccion, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $tipo_direccion->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $tipo_direccion, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $tipo_direccion;
        
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

      $data = TipoDireccion::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}