<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/;

use App\Models\Propietario; 

class PropietarioController
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function getAll()
  {
    try
    {

      $data = Propietario::get();

      return view('admin.propietarios.list-propietarios')->with(compact('data'));
    
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

      return view('admin.propietarios.new-propietario');
    
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
      $celular = $request->input('celular');
      $glosa = $request->input('glosa');
      $estado = $request->input('estado');

      $propietario = Propietario::where(["nombre" => $nombre])->first();

      if (empty($propietario))
      {
        $propietario = new Propietario();
        $propietario->nombre = $nombre;
        $propietario->apellidos = $apellidos;
        $propietario->email = $email;
        $propietario->celular = $celular;
        $propietario->glosa = $glosa;
        $propietario->estado = $estado;
        
        $status = $propietario->save();
        
        $id = $propietario->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$propietario],];
    
      return redirect()->route('admin-propietarios');
    
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

      $data = Propietario::find($id);

      return view('admin.propietarios.edit-propietario')->with(compact('data'));
    
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
      $celular = $request->input('celular');
      $glosa = $request->input('glosa');

      if (!empty($id))
      {
        $propietario = Propietario::find($id);
        $propietario->id = $id;
        $propietario->nombre = $nombre;
        $propietario->apellidos = $apellidos;
        $propietario->email = $email;
        $propietario->celular = $celular;
        $propietario->glosa = $glosa;
        
        $status = $propietario->save();
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-propietarios');;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function find( $id )
  {
    try
    {

      $data = Propietario::find($id);

      return $data;
    
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

      $propietario = Propietario::find( $id ) ;

      if (!empty($propietario))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $propietario->estado = $estado;
          $propietario->save();
            
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $propietario->forceDelete();
        
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

  public function updateStatus( $params = array() )
  {
    try
    {
      extract($params) ;

      $status  = false;
      $message = "";

      if (empty($id))
      {
        $propietario = Propietario::find($id);
        $propietario->estado = $estado;
        
        $status = $propietario->save();
        
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

      $data = Propietario::where("estado", $estado)->get();

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}