<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\UserSession; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class UserSessionController
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

      $data = UserSession::get();

      return view($this->prefixView.'.user-sessions.list-user-sessions')->with(compact('data'));
    
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

      return view($this->prefixView.'.user-sessions.new-user-session');
    
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
      $date_login = $request->input('date_login');
      $date_logout = $request->input('date_logout');
      $token = $request->input('token');

      $user_session = UserSession::where(["user_id" => $user_id])->first();

      if (empty($user_session))
      {

        $user_session = new UserSession();
        $user_session->user_id = $user_id;
        $user_session->date_login = $date_login;
        $user_session->date_logout = $date_logout;
        $user_session->token = $token;
        
        $status = $user_session->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $user_session, "created") ;
        
        $id = $user_session->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$user_session],];
    
      return redirect()->route('admin-user-sessions');
    
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

      $user_session = UserSession::find( $id );

      return view($this->prefixView.'.user-sessions.edit-user-session')->with(compact('user_session'));
    
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
      $date_login = $request->input('date_login');
      $date_logout = $request->input('date_logout');
      $token = $request->input('token');

      if (!empty($id))
      {
        $user_session = UserSession::find($id);
        $user_session->id = $id;
        $user_session->user_id = $user_id;
        $user_session->date_login = $date_login;
        $user_session->date_logout = $date_logout;
        $user_session->token = $token;
        
        $status = $user_session->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $user_session, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-user-sessions');;
    
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

      $user_session = UserSession::find( $id ) ;

      if (!empty($user_session))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $user_session->us_estado = $estado;
          $user_session->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $user_session, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $user_session->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $user_session, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $user_session;
        
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

      $data = UserSession::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}