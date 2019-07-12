<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/;

use App\Models\Users; 
use App\Traits\BitacoraTrait;

class UsersController
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

      $data = Users::get();

      return view('admin.users.list-users')->with(compact('data'));
    
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

      return view('admin.users.new-users');
    
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
      $apellidos = $request->input('apellidos');
      $email = $request->input('email');
      $email_verified_at = $request->input('email_verified_at');
      $password = $request->input('password');
      $estado = $request->input('estado');
      $remember_token = $request->input('remember_token');

      $users = Users::where(["nombre" => $nombre])->first();

      if (empty($users))
      {
        $users = new Users();
        $users->nombre = $nombre;
        $users->apellidos = $apellidos;
        $users->email = $email;
        $users->email_verified_at = $email_verified_at;
        $users->password = $password;
        $users->estado = $estado;
        $users->remember_token = $remember_token;
        
        $status = $users->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $users, "created") ;
        
        $id = $users->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$users],];
    
      return redirect()->route('admin-users');
    
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

      $data = Users::find($id);

      return view('admin.users.edit-users')->with(compact('data'));
    
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
      $apellidos = $request->input('apellidos');
      $email = $request->input('email');
      $email_verified_at = $request->input('email_verified_at');
      $password = $request->input('password');
      $remember_token = $request->input('remember_token');

      if (!empty($id))
      {
        $users = Users::find($id);
        $users->id = $id;
        $users->nombre = $nombre;
        $users->apellidos = $apellidos;
        $users->email = $email;
        $users->email_verified_at = $email_verified_at;
        $users->password = $password;
        $users->remember_token = $remember_token;
        
        $status = $users->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $users, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-users');;
    
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

      $users = Users::find( $id ) ;

      if (!empty($users))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $users->estado = $estado;
          $users->save();
            
        # TABLE BITACORA
        $this->savedBitacoraTrait( $users, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $users->forceDelete();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $users, "delete registro") ;
        
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

      $data = Users::find($id);

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
        $users = Users::find($id);
        $users->estado = $estado;
        
        $status = $users->save();
        
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

      $data = Users::where("estado", $estado)->get();

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}