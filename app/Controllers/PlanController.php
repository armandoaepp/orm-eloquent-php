<?php
  namespace App\Controllers;

  /**
   * [Class Controller]
   * Autor: Armando E. Pisfil Puemape
   * twitter: @armandoaepp
   * email: armandoaepp@gmail.com
  */

  use App\Models\Plan; 

class PlanController
{
  public function __construct()
  {    $this->middleware('auth');
  }

  public function getAll( $id )
  {
    try
    {

      $data = Plan::get();

      return view('admin.plans.list-plans')->with(compact('data'));
    
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

       return view('admin.plans.new-plan');
    
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
      $espacio = $request->input('espacio');
      $num_databases = $request->input('num_databases');
      $num_mails = $request->input('num_mails');
      $estado = $request->input('estado');

      $plan = Plan::where(["nombre" => $nombre])->first();

      if (empty($plan))
      {
        $plan = new Plan();
        $plan->nombre = $nombre;
        $plan->espacio = $espacio;
        $plan->num_databases = $num_databases;
        $plan->num_mails = $num_mails;
        $plan->estado = $estado;
        
        $status = $plan->save();
        
        $id = $plan->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$plan],];
    
      return redirect()->route('admin-plans');
    
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

       $data = Plan::find($id);

       return view('admin.plans.edit-plan')->with(compact('data'));
    
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

        $id = $request->input(id);
        $nombre = $request->input(nombre);
        $espacio = $request->input(espacio);
        $num_databases = $request->input(num_databases);
        $num_mails = $request->input(num_mails);

      if (empty($id))
      {
        $plan = Plan::find($id);
        $plan->id = $id;
        $plan->nombre = $nombre;
        $plan->espacio = $espacio;
        $plan->num_databases = $num_databases;
        $plan->num_mails = $num_mails;
        
        $status = $plan->save();
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-plans');;
    
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

      $data = Plan::find($id);

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

      $plan = Plan::find( $id ) ;

      if (empty($plan))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $plan->estado = 1;
          $plan->save();
            
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $plan->forceDelete();
        
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
                "errors"  =>  [$e->getMessage(), ],
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
        $plan = Plan::find($id);
        $plan->estado = $estado;
        
        $status = $plan->save();
        
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

      $data = Plan::where("estado", $estado)->get();

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}