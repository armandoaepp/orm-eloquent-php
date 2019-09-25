<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\PaqueteAdicional; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PaqueteAdicionalController
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

      $data = PaqueteAdicional::get();

      return view($this->prefixView.'.paquete-adicionals.list-paquete-adicionals')->with(compact('data'));
    
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

      return view($this->prefixView.'.paquete-adicionals.new-paquete-adicional');
    
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

      $paquete_id = $request->input('paquete_id');
      $adicional_id = $request->input('adicional_id');
      $pa_precio = $request->input('pa_precio');
      $pa_estado = !empty($request->input('pa_estado')) ? $request->input('pa_estado') : 1;

      $paquete_adicional = PaqueteAdicional::where(["paquete_id" => $paquete_id])->first();

      if (empty($paquete_adicional))
      {

        $paquete_adicional = new PaqueteAdicional();
        $paquete_adicional->paquete_id = $paquete_id;
        $paquete_adicional->adicional_id = $adicional_id;
        $paquete_adicional->pa_precio = $pa_precio;
        $paquete_adicional->pa_estado = $pa_estado;
        
        $status = $paquete_adicional->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $paquete_adicional, "created") ;
        
        $id = $paquete_adicional->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$paquete_adicional],];
    
      return redirect()->route('admin-paquete-adicionals');
    
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

      $paquete_adicional = PaqueteAdicional::find( $id );

      return view($this->prefixView.'.paquete-adicionals.edit-paquete-adicional')->with(compact('paquete_adicional'));
    
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
      $paquete_id = $request->input('paquete_id');
      $adicional_id = $request->input('adicional_id');
      $pa_precio = $request->input('pa_precio');

      if (!empty($id))
      {
        $paquete_adicional = PaqueteAdicional::find($id);
        $paquete_adicional->id = $id;
        $paquete_adicional->paquete_id = $paquete_id;
        $paquete_adicional->adicional_id = $adicional_id;
        $paquete_adicional->pa_precio = $pa_precio;
        
        $status = $paquete_adicional->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $paquete_adicional, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-paquete-adicionals');;
    
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

      $paquete_adicional = PaqueteAdicional::find( $id ) ;

      if (!empty($paquete_adicional))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $paquete_adicional->pa_estado = $estado;
          $paquete_adicional->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $paquete_adicional, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $paquete_adicional->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $paquete_adicional, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $paquete_adicional;
        
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

      $data = PaqueteAdicional::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}