<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Contacto; 
use App\Traits\BitacoraTrait;

class ContactoController
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

      $data = Contacto::get();

      return view('admin.contactos.list-contactos')->with(compact('data'));
    
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

      return view('admin.contactos.new-contacto');
    
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

      $per_id_padre = $request->input('per_id_padre');
      $nombre = $request->input('nombre');
      $apellidos = $request->input('apellidos');
      $email = $request->input('email');
      $estado = $request->input('estado');

      $contacto = Contacto::where(["per_id_padre" => $per_id_padre])->first();

      if (empty($contacto))
      {
        $contacto = new Contacto();
        $contacto->per_id_padre = $per_id_padre;
        $contacto->nombre = $nombre;
        $contacto->apellidos = $apellidos;
        $contacto->email = $email;
        $contacto->estado = $estado;
        
        $status = $contacto->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $contacto, "created") ;
        
        $id = $contacto->contacto_id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$contacto],];
    
      return redirect()->route('admin-contactos');
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function edit( $contacto_id )
  {
    try
    {

      $data = Contacto::find( $contacto_id );

      return view('admin.contactos.edit-contacto')->with(compact('data'));
    
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

      $contacto_id = $request->input('contacto_id');
      $per_id_padre = $request->input('per_id_padre');
      $nombre = $request->input('nombre');
      $apellidos = $request->input('apellidos');
      $email = $request->input('email');

      if (!empty($contacto_id))
      {
        $contacto = Contacto::find($contacto_id);
        $contacto->contacto_id = $contacto_id;
        $contacto->per_id_padre = $per_id_padre;
        $contacto->nombre = $nombre;
        $contacto->apellidos = $apellidos;
        $contacto->email = $email;
        
        $status = $contacto->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $contacto, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-contactos');;
    
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

      $contacto = Contacto::find( $contacto_id ) ;

      if (!empty($contacto))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $contacto->estado = $estado;
          $contacto->save();
            
        # TABLE BITACORA
        $this->savedBitacoraTrait( $contacto, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $contacto->forceDelete();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $contacto, "delete registro") ;
        
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

  public function find( $contacto_id )
  {
    try
    {

      $data = Contacto::find($contacto_id);

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

      if (empty($contacto_id))
      {
        $contacto = Contacto::find($contacto_id);
        $contacto->estado = $estado;
        
        $status = $contacto->save();
        
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

      $data = Contacto::where("estado", $estado)->get();

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}