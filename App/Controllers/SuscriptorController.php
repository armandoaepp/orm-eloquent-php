<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Suscriptor; 
use App\Traits\BitacoraTrait;

class SuscriptorController
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

      $data = Suscriptor::get();

      return view('admin.suscriptors.list-suscriptors')->with(compact('data'));
    
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

      return view('admin.suscriptors.new-suscriptor');
    
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

      $nombre = $request->input('nombre');
      $email = $request->input('email');
      $telefono = $request->input('telefono');
      $empresa = $request->input('empresa');
      $mensaje = $request->input('mensaje');
      $estado = $request->input('estado');

      $suscriptor = Suscriptor::where(["nombre" => $nombre])->first();

      if (empty($suscriptor))
      {
        $suscriptor = new Suscriptor();
        $suscriptor->nombre = $nombre;
        $suscriptor->email = $email;
        $suscriptor->telefono = $telefono;
        $suscriptor->empresa = $empresa;
        $suscriptor->mensaje = $mensaje;
        $suscriptor->estado = $estado;
        
        $status = $suscriptor->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $suscriptor, "created") ;
        
        $id = $suscriptor->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$suscriptor],];
    
      return redirect()->route('admin-suscriptors');
    
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

      $data = Suscriptor::find( $id );

      return view('admin.suscriptors.edit-suscriptor')->with(compact('data'));
    
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
      $nombre = $request->input('nombre');
      $email = $request->input('email');
      $telefono = $request->input('telefono');
      $empresa = $request->input('empresa');
      $mensaje = $request->input('mensaje');

      if (!empty($id))
      {
        $suscriptor = Suscriptor::find($id);
        $suscriptor->id = $id;
        $suscriptor->nombre = $nombre;
        $suscriptor->email = $email;
        $suscriptor->telefono = $telefono;
        $suscriptor->empresa = $empresa;
        $suscriptor->mensaje = $mensaje;
        
        $status = $suscriptor->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $suscriptor, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-suscriptors');;
    
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

      $suscriptor = Suscriptor::find( $id ) ;

      if (!empty($suscriptor))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $suscriptor->estado = $estado;
          $suscriptor->save();
            
        # TABLE BITACORA
        $this->savedBitacoraTrait( $suscriptor, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $suscriptor->forceDelete();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $suscriptor, "delete registro") ;
        
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

      $data = Suscriptor::find($id);

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

      if (empty($id))
      {
        $suscriptor = Suscriptor::find($id);
        $suscriptor->estado = $estado;
        
        $status = $suscriptor->save();
        
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

      $data = Suscriptor::where("estado", $estado)->get();

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}