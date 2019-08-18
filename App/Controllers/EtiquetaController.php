<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Etiqueta; 
use App\Traits\BitacoraTrait;

class EtiquetaController
{
  use BitacoraTrait;

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function getAll()
  {
    try
    {

      $data = Etiqueta::get();

      return view('admin.etiquetas.list-etiquetas')->with(compact('data'));
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function newRegister( Request $request )
  {
    try
    {

      return view('admin.etiquetas.new-etiqueta');
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function save( Request $request )
  {
    try
    {
      $status  = false;
      $message = "";

      $eti_descripcion = $request->input('eti_descripcion');
      $eti_publicar = $request->input('eti_publicar');
      $eti_estado = $request->input('eti_estado');

      $etiqueta = Etiqueta::where(["eti_descripcion" => $eti_descripcion])->first();

      if (empty($etiqueta))
      {
        $etiqueta = new Etiqueta();
        $etiqueta->eti_descripcion = $eti_descripcion;
        $etiqueta->eti_publicar = $eti_publicar;
        $etiqueta->eti_estado = $eti_estado;
        
        $status = $etiqueta->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $etiqueta, "created") ;
        
        $id = $etiqueta->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$etiqueta],];
    
      return redirect()->route('admin-etiquetas');
    
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

      $data = Etiqueta::find( $id );

      return view('admin.etiquetas.edit-etiqueta')->with(compact('data'));
    
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
      $eti_descripcion = $request->input('eti_descripcion');
      $eti_publicar = $request->input('eti_publicar');
      $eti_estado = $request->input('eti_estado');

      if (!empty($id))
      {
        $etiqueta = Etiqueta::find($id);
        $etiqueta->id = $id;
        $etiqueta->eti_descripcion = $eti_descripcion;
        $etiqueta->eti_publicar = $eti_publicar;
        $etiqueta->eti_estado = $eti_estado;
        
        $status = $etiqueta->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $etiqueta, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-etiquetas');;
    
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

      $etiqueta = Etiqueta::find( $id ) ;

      if (!empty($etiqueta))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $etiqueta->estado = $estado;
          $etiqueta->save();
            
        # TABLE BITACORA
        $this->savedBitacoraTrait( $etiqueta, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $etiqueta->forceDelete();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $etiqueta, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
         $data = $plan;
        
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
                "status"  => $status,
                "errors"  => [$e->getMessage(), ],
                "data"    => [],
              ]);
    }

  }

  public function find( $id )
  {
    try
    {

      $data = Etiqueta::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}