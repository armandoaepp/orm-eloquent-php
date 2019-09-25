<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Notificacion; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class NotificacionController
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

      $data = Notificacion::get();

      return view($this->prefixView.'.notificacions.list-notificacions')->with(compact('data'));
    
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

      return view($this->prefixView.'.notificacions.new-notificacion');
    
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
      $asunto = $request->input('asunto');
      $destino = $request->input('destino');
      $mensaje = $request->input('mensaje');
      $referencia = $request->input('referencia');
      $tipo = $request->input('tipo');
      $fecha_envio = $request->input('fecha_envio');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      $notificacion = Notificacion::where(["user_id" => $user_id])->first();

      if (empty($notificacion))
      {

        $notificacion = new Notificacion();
        $notificacion->user_id = $user_id;
        $notificacion->asunto = $asunto;
        $notificacion->destino = $destino;
        $notificacion->mensaje = $mensaje;
        $notificacion->referencia = $referencia;
        $notificacion->tipo = $tipo;
        $notificacion->fecha_envio = $fecha_envio;
        $notificacion->estado = $estado;
        
        $status = $notificacion->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $notificacion, "created") ;
        
        $id = $notificacion->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$notificacion],];
    
      return redirect()->route('admin-notificacions');
    
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

      $notificacion = Notificacion::find( $id );

      return view($this->prefixView.'.notificacions.edit-notificacion')->with(compact('notificacion'));
    
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
      $asunto = $request->input('asunto');
      $destino = $request->input('destino');
      $mensaje = $request->input('mensaje');
      $referencia = $request->input('referencia');
      $tipo = $request->input('tipo');
      $fecha_envio = $request->input('fecha_envio');

      if (!empty($id))
      {
        $notificacion = Notificacion::find($id);
        $notificacion->id = $id;
        $notificacion->user_id = $user_id;
        $notificacion->asunto = $asunto;
        $notificacion->destino = $destino;
        $notificacion->mensaje = $mensaje;
        $notificacion->referencia = $referencia;
        $notificacion->tipo = $tipo;
        $notificacion->fecha_envio = $fecha_envio;
        
        $status = $notificacion->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $notificacion, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-notificacions');;
    
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

      $notificacion = Notificacion::find( $id ) ;

      if (!empty($notificacion))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $notificacion->estado = $estado;
          $notificacion->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $notificacion, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $notificacion->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $notificacion, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $notificacion;
        
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

      $data = Notificacion::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}