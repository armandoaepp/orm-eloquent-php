<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Lista; 
use App\Traits\BitacoraTrait;

class ListaController
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

      $data = Lista::get();

      return view('admin.listas.list-listas')->with(compact('data'));
    
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

      return view('admin.listas.new-lista');
    
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
      $desc_lista = $request->input('desc_lista');
      $estado = $request->input('estado');

      $lista = Lista::where(["per_id_padre" => $per_id_padre])->first();

      if (empty($lista))
      {
        $lista = new Lista();
        $lista->per_id_padre = $per_id_padre;
        $lista->desc_lista = $desc_lista;
        $lista->estado = $estado;
        
        $status = $lista->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $lista, "created") ;
        
        $id = $lista->lista_id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$lista],];
    
      return redirect()->route('admin-listas');
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function edit( $lista_id )
  {
    try
    {

      $data = Lista::find( $lista_id );

      return view('admin.listas.edit-lista')->with(compact('data'));
    
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

      $lista_id = $request->input('lista_id');
      $per_id_padre = $request->input('per_id_padre');
      $desc_lista = $request->input('desc_lista');

      if (!empty($lista_id))
      {
        $lista = Lista::find($lista_id);
        $lista->lista_id = $lista_id;
        $lista->per_id_padre = $per_id_padre;
        $lista->desc_lista = $desc_lista;
        
        $status = $lista->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $lista, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-listas');;
    
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

      $lista = Lista::find( $lista_id ) ;

      if (!empty($lista))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $lista->estado = $estado;
          $lista->save();
            
        # TABLE BITACORA
        $this->savedBitacoraTrait( $lista, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $lista->forceDelete();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $lista, "delete registro") ;
        
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

  public function find( $lista_id )
  {
    try
    {

      $data = Lista::find($lista_id);

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

      if (empty($lista_id))
      {
        $lista = Lista::find($lista_id);
        $lista->estado = $estado;
        
        $status = $lista->save();
        
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

      $data = Lista::where("estado", $estado)->get();

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}