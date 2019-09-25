<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Itinerario; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class ItinerarioController
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

      $data = Itinerario::get();

      return view($this->prefixView.'.itinerarios.list-itinerarios')->with(compact('data'));
    
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

      return view($this->prefixView.'.itinerarios.new-itinerario');
    
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

      $paquete_id = $request->input('paquete_id');
      $iti_dia = $request->input('iti_dia');
      $iti_titulo = $request->input('iti_titulo');
      $iti_descripcion = $request->input('iti_descripcion');
      $iti_estado = !empty($request->input('iti_estado')) ? $request->input('iti_estado') : 1;

      $itinerario = Itinerario::where(["paquete_id" => $paquete_id])->first();

      if (empty($itinerario))
      {

        $itinerario = new Itinerario();
        $itinerario->paquete_id = $paquete_id;
        $itinerario->iti_dia = $iti_dia;
        $itinerario->iti_titulo = $iti_titulo;
        $itinerario->iti_descripcion = $iti_descripcion;
        $itinerario->iti_estado = $iti_estado;
        
        $status = $itinerario->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $itinerario, "created") ;
        
        $id = $itinerario->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$itinerario],];
    
      return redirect()->route('admin-itinerarios');
    
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

      $itinerario = Itinerario::find( $id );

      return view($this->prefixView.'.itinerarios.edit-itinerario')->with(compact('itinerario'));
    
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
      $paquete_id = $request->input('paquete_id');
      $iti_dia = $request->input('iti_dia');
      $iti_titulo = $request->input('iti_titulo');
      $iti_descripcion = $request->input('iti_descripcion');

      if (!empty($id))
      {
        $itinerario = Itinerario::find($id);
        $itinerario->id = $id;
        $itinerario->paquete_id = $paquete_id;
        $itinerario->iti_dia = $iti_dia;
        $itinerario->iti_titulo = $iti_titulo;
        $itinerario->iti_descripcion = $iti_descripcion;
        
        $status = $itinerario->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $itinerario, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-itinerarios');;
    
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

      $itinerario = Itinerario::find( $id ) ;

      if (!empty($itinerario))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $itinerario->iti_estado = $estado;
          $itinerario->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $itinerario, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $itinerario->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $itinerario, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $itinerario;
        
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

      $data = Itinerario::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}