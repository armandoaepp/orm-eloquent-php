<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Pais; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PaisController
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

      $data = Pais::get();

      return view($this->prefixView.'.pais.list-pais')->with(compact('data'));
    
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

      return view($this->prefixView.'.pais.new-pais');
    
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

      $code = $request->input('code');
      $nombre = $request->input('nombre');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      $pais = Pais::where(["code" => $code])->first();

      if (empty($pais))
      {

        $pais = new Pais();
        $pais->code = $code;
        $pais->nombre = $nombre;
        $pais->estado = $estado;
        
        $status = $pais->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $pais, "created") ;
        
        $id = $pais->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$pais],];
    
      return redirect()->route('admin-pais');
    
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

      $pais = Pais::find( $id );

      return view($this->prefixView.'.pais.edit-pais')->with(compact('pais'));
    
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
      $code = $request->input('code');
      $nombre = $request->input('nombre');

      if (!empty($id))
      {
        $pais = Pais::find($id);
        $pais->id = $id;
        $pais->code = $code;
        $pais->nombre = $nombre;
        
        $status = $pais->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $pais, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-pais');;
    
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

      $pais = Pais::find( $id ) ;

      if (!empty($pais))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $pais->estado = $estado;
          $pais->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $pais, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $pais->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $pais, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $pais;
        
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

      $data = Pais::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}