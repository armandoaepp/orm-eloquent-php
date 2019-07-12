<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Mensaje; 
use App\Traits\BitacoraTrait;

class MensajeController
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

      $data = Mensaje::get();

      return view('admin.mensajes.list-mensajes')->with(compact('data'));
    
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

      return view('admin.mensajes.new-mensaje');
    
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

      $lista_contacto_id = $request->input('lista_contacto_id');
      $email = $request->input('email');
      $asunto = $request->input('asunto');
      $header = $request->input('header');
      $body = $request->input('body');
      $glosa = $request->input('glosa');
      $estado = $request->input('estado');

      $mensaje = Mensaje::where(["lista_contacto_id" => $lista_contacto_id])->first();

      if (empty($mensaje))
      {
        $mensaje = new Mensaje();
        $mensaje->lista_contacto_id = $lista_contacto_id;
        $mensaje->email = $email;
        $mensaje->asunto = $asunto;
        $mensaje->header = $header;
        $mensaje->body = $body;
        $mensaje->glosa = $glosa;
        $mensaje->estado = $estado;
        
        $status = $mensaje->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $mensaje, "created") ;
        
        $id = $mensaje->mensaje_id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$mensaje],];
    
      return redirect()->route('admin-mensajes');
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function edit( $mensaje_id )
  {
    try
    {

      $data = Mensaje::find( $mensaje_id );

      return view('admin.mensajes.edit-mensaje')->with(compact('data'));
    
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

      $mensaje_id = $request->input('mensaje_id');
      $lista_contacto_id = $request->input('lista_contacto_id');
      $email = $request->input('email');
      $asunto = $request->input('asunto');
      $header = $request->input('header');
      $body = $request->input('body');
      $glosa = $request->input('glosa');

      if (!empty($mensaje_id))
      {
        $mensaje = Mensaje::find($mensaje_id);
        $mensaje->mensaje_id = $mensaje_id;
        $mensaje->lista_contacto_id = $lista_contacto_id;
        $mensaje->email = $email;
        $mensaje->asunto = $asunto;
        $mensaje->header = $header;
        $mensaje->body = $body;
        $mensaje->glosa = $glosa;
        
        $status = $mensaje->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $mensaje, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-mensajes');;
    
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

      $mensaje = Mensaje::find( $mensaje_id ) ;

      if (!empty($mensaje))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $mensaje->estado = $estado;
          $mensaje->save();
            
        # TABLE BITACORA
        $this->savedBitacoraTrait( $mensaje, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $mensaje->forceDelete();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $mensaje, "delete registro") ;
        
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

  public function find( $mensaje_id )
  {
    try
    {

      $data = Mensaje::find($mensaje_id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function updateStatus( $params = array() )
  {
    try
    {
      extract($params) ;

      $status  = false;
      $message = "";

      if (empty($mensaje_id))
      {
        $mensaje = Mensaje::find($mensaje_id);
        $mensaje->estado = $estado;
        
        $status = $mensaje->save();
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El identificador es incorrecto!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function getByStatus( $params = array()  )
  {
    try
    {
      extract($params) ;

      $data = Mensaje::where("estado", $estado)->get();

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}