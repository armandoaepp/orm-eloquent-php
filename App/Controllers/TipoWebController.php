<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\TipoWeb; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class TipoWebController
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

      $data = TipoWeb::get();

      return view($this->prefixView.'.tipo-webs.list-tipo-webs')->with(compact('data'));
    
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

      return view($this->prefixView.'.tipo-webs.new-tipo-web');
    
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

      $tw_descripcion = $request->input('tw_descripcion');
      $tw_estado = !empty($request->input('tw_estado')) ? $request->input('tw_estado') : 1;

      $tipo_web = TipoWeb::where(["tw_descripcion" => $tw_descripcion])->first();

      if (empty($tipo_web))
      {

        $tipo_web = new TipoWeb();
        $tipo_web->tw_descripcion = $tw_descripcion;
        $tipo_web->tw_estado = $tw_estado;
        
        $status = $tipo_web->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_web, "created") ;
        
        $id = $tipo_web->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$tipo_web],];
    
      return redirect()->route('admin-tipo-webs');
    
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

      $tipo_web = TipoWeb::find( $id );

      return view($this->prefixView.'.tipo-webs.edit-tipo-web')->with(compact('tipo_web'));
    
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
      $tw_descripcion = $request->input('tw_descripcion');

      if (!empty($id))
      {
        $tipo_web = TipoWeb::find($id);
        $tipo_web->id = $id;
        $tipo_web->tw_descripcion = $tw_descripcion;
        
        $status = $tipo_web->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $tipo_web, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-tipo-webs');;
    
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

      $tipo_web = TipoWeb::find( $id ) ;

      if (!empty($tipo_web))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $tipo_web->tw_estado = $estado;
          $tipo_web->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $tipo_web, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $tipo_web->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $tipo_web, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $tipo_web;
        
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

      $data = TipoWeb::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}