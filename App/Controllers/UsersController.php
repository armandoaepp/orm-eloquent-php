<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Users; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class UsersController
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

      $data = Users::get();

      return view($this->prefixView.'.users.list-users')->with(compact('data'));
    
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

      return view($this->prefixView.'.users.new-users');
    
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

      $per_id_padre = $request->input('per_id_padre');
      $rol_id = $request->input('rol_id');
      $persona_id = $request->input('persona_id');
      $email = $request->input('email');
      $password = $request->input('password');
      $nombre = $request->input('nombre');
      $apellidos = $request->input('apellidos');
      $alias = $request->input('alias');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;
      $email_verified_at = $request->input('email_verified_at');
      $remember_token = $request->input('remember_token');

      $users = Users::where(["per_id_padre" => $per_id_padre])->first();

      if (empty($users))
      {

        $users = new Users();
        $users->per_id_padre = $per_id_padre;
        $users->rol_id = $rol_id;
        $users->persona_id = $persona_id;
        $users->email = $email;
        $users->password = $password;
        $users->nombre = $nombre;
        $users->apellidos = $apellidos;
        $users->alias = $alias;
        $users->estado = $estado;
        $users->email_verified_at = $email_verified_at;
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

      $users = Users::find( $id );

      return view($this->prefixView.'.users.edit-users')->with(compact('users'));
    
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
      $per_id_padre = $request->input('per_id_padre');
      $rol_id = $request->input('rol_id');
      $persona_id = $request->input('persona_id');
      $email = $request->input('email');
      $password = $request->input('password');
      $nombre = $request->input('nombre');
      $apellidos = $request->input('apellidos');
      $alias = $request->input('alias');
      $email_verified_at = $request->input('email_verified_at');
      $remember_token = $request->input('remember_token');

      if (!empty($id))
      {
        $users = Users::find($id);
        $users->id = $id;
        $users->per_id_padre = $per_id_padre;
        $users->rol_id = $rol_id;
        $users->persona_id = $persona_id;
        $users->email = $email;
        $users->password = $password;
        $users->nombre = $nombre;
        $users->apellidos = $apellidos;
        $users->alias = $alias;
        $users->email_verified_at = $email_verified_at;
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
        
        $data = $users;
        
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

      $data = Users::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}