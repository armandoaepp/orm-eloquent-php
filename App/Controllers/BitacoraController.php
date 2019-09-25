<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Bitacora; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class BitacoraController
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

      $data = Bitacora::get();

      return view($this->prefixView.'.bitacoras.list-bitacoras')->with(compact('data'));
    
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

      return view($this->prefixView.'.bitacoras.new-bitacora');
    
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
      $action = $request->input('action');
      $table_id = $request->input('table_id');
      $table = $request->input('table');
      $computer_ip = $request->input('computer_ip');
      $new_value = $request->input('new_value');
      $old_value = $request->input('old_value');

      $bitacora = Bitacora::where(["user_id" => $user_id])->first();

      if (empty($bitacora))
      {

        $bitacora = new Bitacora();
        $bitacora->user_id = $user_id;
        $bitacora->action = $action;
        $bitacora->table_id = $table_id;
        $bitacora->table = $table;
        $bitacora->computer_ip = $computer_ip;
        $bitacora->new_value = $new_value;
        $bitacora->old_value = $old_value;
        
        $status = $bitacora->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $bitacora, "created") ;
        
        $id = $bitacora->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$bitacora],];
    
      return redirect()->route('admin-bitacoras');
    
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

      $bitacora = Bitacora::find( $id );

      return view($this->prefixView.'.bitacoras.edit-bitacora')->with(compact('bitacora'));
    
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
      $action = $request->input('action');
      $table_id = $request->input('table_id');
      $table = $request->input('table');
      $computer_ip = $request->input('computer_ip');
      $new_value = $request->input('new_value');
      $old_value = $request->input('old_value');

      if (!empty($id))
      {
        $bitacora = Bitacora::find($id);
        $bitacora->id = $id;
        $bitacora->user_id = $user_id;
        $bitacora->action = $action;
        $bitacora->table_id = $table_id;
        $bitacora->table = $table;
        $bitacora->computer_ip = $computer_ip;
        $bitacora->new_value = $new_value;
        $bitacora->old_value = $old_value;
        
        $status = $bitacora->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $bitacora, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-bitacoras');;
    
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

      $bitacora = Bitacora::find( $id ) ;

      if (!empty($bitacora))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $bitacora->bit_estado = $estado;
          $bitacora->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $bitacora, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $bitacora->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $bitacora, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $bitacora;
        
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

      $data = Bitacora::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}