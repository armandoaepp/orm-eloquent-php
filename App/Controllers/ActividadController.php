<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Actividad; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class ActividadController
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

      $data = Actividad::get();

      return view($this->prefixView.'.actividads.list-actividads')->with(compact('data'));
    
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

      return view($this->prefixView.'.actividads.new-actividad');
    
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

      $act_nombre = $request->input('act_nombre');
      $act_horas = $request->input('act_horas');
      $act_descripcion = $request->input('act_descripcion');
      $act_publicar = $request->input('act_publicar');
      $act_estado = !empty($request->input('act_estado')) ? $request->input('act_estado') : 1;

      $actividad = Actividad::where(["act_nombre" => $act_nombre])->first();

      if (empty($actividad))
      {

        $actividad = new Actividad();
        $actividad->act_nombre = $act_nombre;
        $actividad->act_horas = $act_horas;
        $actividad->act_descripcion = $act_descripcion;
        $actividad->act_publicar = $act_publicar;
        $actividad->act_estado = $act_estado;
        
        $status = $actividad->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $actividad, "created") ;
        
        $id = $actividad->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$actividad],];
    
      return redirect()->route('admin-actividads');
    
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

      $actividad = Actividad::find( $id );

      return view($this->prefixView.'.actividads.edit-actividad')->with(compact('actividad'));
    
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
      $act_nombre = $request->input('act_nombre');
      $act_horas = $request->input('act_horas');
      $act_descripcion = $request->input('act_descripcion');
      $act_publicar = $request->input('act_publicar');

      if (!empty($id))
      {
        $actividad = Actividad::find($id);
        $actividad->id = $id;
        $actividad->act_nombre = $act_nombre;
        $actividad->act_horas = $act_horas;
        $actividad->act_descripcion = $act_descripcion;
        $actividad->act_publicar = $act_publicar;
        
        $status = $actividad->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $actividad, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-actividads');;
    
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

      $actividad = Actividad::find( $id ) ;

      if (!empty($actividad))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $actividad->act_estado = $estado;
          $actividad->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $actividad, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $actividad->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $actividad, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $actividad;
        
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

  public function updatePublish( Request $request )
  {
    try
    {
      $status  = false;
      $message = "";

      $id = $request->input("id");
      $publicar = $request->input("publicar");

      if (!empty($id))
      {

        if ($publicar == "N") {
          $publicar = "S";
          $message = "Registro Publicado";
        } else {
          $publicar = "N";
          $message = "Registro Ocultado al público";
        }

        $actividad = Actividad::find($id);
        if (!empty($actividad))
        {
          $actividad->act_publicar = $publicar;
          $actividad->save();

          # TABLE BITACORA
          $this->savedBitacoraTrait( $actividad, "update publicar: ".$publicar) ;

          $status = true;
          $message = $message;

         $data = $actividad;
        }
        else
        {
          $message = "¡El registro no exite o el identificador es incorrecto!";
          $data = $request->all();
        }
        
      }
      else
      {
        $message = "¡El identificador es incorrecto!";
        $data = $request->all();
      }

        return \Response::json([
                "message" => $message,
                "status"  => $status,
                "errors"  => [],
                "data"    => [$data],
              ]);
    
    }
    catch (Exception $e)
    {
        return \Response::json([
                "message" => "Operación fallida en el servidor",
                "status"  => false,
                "errors"  => [$e->getMessage()],
                "data"    => [],
              ]);
    }

  }

  public function getPublished(  $params = array()  )
  {
    try
    {
      extract($params) ;

      $data = Actividad::where("act_publicar", $act_publicar)->get();

      return $data;
    
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

      $data = Actividad::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}