<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\PerWeb; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PerWebController
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

      $data = PerWeb::get();

      return view($this->prefixView.'.per-webs.list-per-webs')->with(compact('data'));
    
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

      return view($this->prefixView.'.per-webs.new-per-web');
    
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

      $persona_id = $request->input('persona_id');
      $tipo_web_id = $request->input('tipo_web_id');
      $pw_url = $request->input('pw_url');
      $pw_estado = !empty($request->input('pw_estado')) ? $request->input('pw_estado') : 1;

      $per_web = PerWeb::where(["persona_id" => $persona_id])->first();

      if (empty($per_web))
      {

        $per_web = new PerWeb();
        $per_web->persona_id = $persona_id;
        $per_web->tipo_web_id = $tipo_web_id;
        $per_web->pw_url = $pw_url;
        $per_web->pw_estado = $pw_estado;
        
        $status = $per_web->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $per_web, "created") ;
        
        $id = $per_web->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$per_web],];
    
      return redirect()->route('admin-per-webs');
    
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

      $per_web = PerWeb::find( $id );

      return view($this->prefixView.'.per-webs.edit-per-web')->with(compact('per_web'));
    
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
      $persona_id = $request->input('persona_id');
      $tipo_web_id = $request->input('tipo_web_id');
      $pw_url = $request->input('pw_url');

      if (!empty($id))
      {
        $per_web = PerWeb::find($id);
        $per_web->id = $id;
        $per_web->persona_id = $persona_id;
        $per_web->tipo_web_id = $tipo_web_id;
        $per_web->pw_url = $pw_url;
        
        $status = $per_web->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $per_web, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-per-webs');;
    
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

      $per_web = PerWeb::find( $id ) ;

      if (!empty($per_web))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $per_web->pw_estado = $estado;
          $per_web->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $per_web, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $per_web->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $per_web, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $per_web;
        
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

      $data = PerWeb::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}