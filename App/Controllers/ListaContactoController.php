<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\ListaContacto; 
use App\Traits\BitacoraTrait;

class ListaContactoController
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

      $data = ListaContacto::get();

      return view('admin.lista-contactos.list-lista-contactos')->with(compact('data'));
    
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

      return view('admin.lista-contactos.new-lista-contacto');
    
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

      $contacto_id = $request->input('contacto_id');
      $lista_id = $request->input('lista_id');
      $estado = $request->input('estado');

      $lista_contacto = ListaContacto::where(["contacto_id" => $contacto_id])->first();

      if (empty($lista_contacto))
      {
        $lista_contacto = new ListaContacto();
        $lista_contacto->contacto_id = $contacto_id;
        $lista_contacto->lista_id = $lista_id;
        $lista_contacto->estado = $estado;
        
        $status = $lista_contacto->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $lista_contacto, "created") ;
        
        $id = $lista_contacto->lista_contacto_id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$lista_contacto],];
    
      return redirect()->route('admin-lista-contactos');
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function edit( $lista_contacto_id )
  {
    try
    {

      $data = ListaContacto::find( $lista_contacto_id );

      return view('admin.lista-contactos.edit-lista-contacto')->with(compact('data'));
    
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

      $lista_contacto_id = $request->input('lista_contacto_id');
      $contacto_id = $request->input('contacto_id');
      $lista_id = $request->input('lista_id');

      if (!empty($lista_contacto_id))
      {
        $lista_contacto = ListaContacto::find($lista_contacto_id);
        $lista_contacto->lista_contacto_id = $lista_contacto_id;
        $lista_contacto->contacto_id = $contacto_id;
        $lista_contacto->lista_id = $lista_id;
        
        $status = $lista_contacto->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $lista_contacto, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-lista-contactos');;
    
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

      $lista_contacto = ListaContacto::find( $lista_contacto_id ) ;

      if (!empty($lista_contacto))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $lista_contacto->estado = $estado;
          $lista_contacto->save();
            
        # TABLE BITACORA
        $this->savedBitacoraTrait( $lista_contacto, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $lista_contacto->forceDelete();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $lista_contacto, "delete registro") ;
        
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

  public function find( $lista_contacto_id )
  {
    try
    {

      $data = ListaContacto::find($lista_contacto_id);

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

      if (empty($lista_contacto_id))
      {
        $lista_contacto = ListaContacto::find($lista_contacto_id);
        $lista_contacto->estado = $estado;
        
        $status = $lista_contacto->save();
        
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

      $data = ListaContacto::where("estado", $estado)->get();

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}