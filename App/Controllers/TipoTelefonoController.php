<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\TipoTelefono; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class TipoTelefonoController
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

      $data = TipoTelefono::get();

      return view($this->prefixView.'.tipo-telefonos.list-tipo-telefonos')->with(compact('data'));
    
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

      return view($this->prefixView.'.tipo-telefonos.new-tipo-telefono');
    
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

      $tt_descripcion = $request->input('tt_descripcion');
      $tt_estado = !empty($request->input('tt_estado')) ? $request->input('tt_estado') : 1;

      $tipo_telefono = TipoTelefono::where(["tt_descripcion" => $tt_descripcion])->first();

      if (empty($tipo_telefono))
      {

        $tipo_telefono = new TipoTelefono();
        $tipo_telefono->tt_descripcion = $tt_descripcion;
        $tipo_telefono->tt_estado = $tt_estado;
        
        $status = $tipo_telefono->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_telefono, "created") ;
        
        $id = $tipo_telefono->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$tipo_telefono],];
    
      return redirect()->route('admin-tipo-telefonos');
    
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

      $tipo_telefono = TipoTelefono::find( $id );

      return view($this->prefixView.'.tipo-telefonos.edit-tipo-telefono')->with(compact('tipo_telefono'));
    
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
      $tt_descripcion = $request->input('tt_descripcion');

      if (!empty($id))
      {
        $tipo_telefono = TipoTelefono::find($id);
        $tipo_telefono->id = $id;
        $tipo_telefono->tt_descripcion = $tt_descripcion;
        
        $status = $tipo_telefono->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_telefono, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-tipo-telefonos');;
    
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

      $tipo_telefono = TipoTelefono::find( $id ) ;

      if (!empty($tipo_telefono))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $tipo_telefono->tt_estado = $estado;
          $tipo_telefono->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $tipo_telefono, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $tipo_telefono->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $tipo_telefono, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $tipo_telefono;
        
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

      $data = TipoTelefono::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}