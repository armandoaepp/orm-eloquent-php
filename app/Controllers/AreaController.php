<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Area; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class AreaController
{
  use BitacoraTrait, UploadFiles;

  protected $prefixView = "admin";

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    try
    {

      $data = Area::get();

      return view($this->prefixView.'.areas.list-areas')->with(compact('data'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function create(Request $request )
  {
    try
    {

      if ($request->ajax()) {
        return view($this->prefixView.'.areas.form-create-area');
      }

      return view($this->prefixView.'.areas.new-area');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(Request $request )
  {
    try
    {
      $success = false;
      $message = "";




      $area_id_sup = $request->input('area_id_sup');
      $descripcion = $request->input('descripcion');
      $grupo_id = $request->input('grupo_id');
      $nivel = $request->input('nivel');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $area = new Area();
        $area->area_id_sup = $area_id_sup;
        $area->descripcion = $descripcion;
        $area->grupo_id = $grupo_id;
        $area->nivel = $nivel;
        $area->estado = $estado;
        
        $status = $area->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $area, "created") ;
        
        
      $message = "Operancion Correcta";
        

      $data = ["message" => $message, "status" => $status, "data" => [$area],];
    
      return redirect()->route('admin-areas');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function edit( $id )
  {
    try
    {

      $area = Area::find( $id );

      return view($this->prefixView.'.areas.edit-area')->with(compact('area'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function update(Request $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id = $request->input('id');
      $area_id_sup = $request->input('area_id_sup');
      $descripcion = $request->input('descripcion');
      $grupo_id = $request->input('grupo_id');
      $nivel = $request->input('nivel');

      if (!empty($id))
      {
        $area = Area::find($id);
        $area->id = $id;
        $area->area_id_sup = $area_id_sup;
        $area->descripcion = $descripcion;
        $area->grupo_id = $grupo_id;
        $area->nivel = $nivel;
        
        $status = $area->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $area, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-areas');;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function delete(Request $request )
  {
    try
    {
      $validator = \Validator::make($request->all(), [
        'id'     => 'numeric',
        'estado' => 'numeric',
      ]);

      $success = false;
      $message = "";

      if ($request->ajax())
      {
        if ($validator->fails())
        {
          return response()->json([
              "message" => "Error al realizar operación",
              "status"  => false,
              "errors"  => $validator->errors()->all(),
              "data"    => [],
            ]);
        }

        $id        = $request->input('id');
        $estado    = $request->input('estado');
        $historial = !empty($request->input('historial')) ? $request->input('historial') : "si";

        if ($estado == 1) {
          $estado = 0;
          $message = "Registro Desactivo Correctamente";
        } else {
          $estado = 1;
          $message = "Registro Activado Correctamente";
        }

        $area = Area::find( $id ) ;

        if (!empty($area))
        {
          #conservar en base de datos
          if ( $historial == "si" )
          {
            $area->estado = $estado;
            $area->save();
              
            # TABLE BITACORA
            $this->savedBitacoraTrait( $area, "update estado") ;
          
            $status = true;
            //$message = $message;
              
          }elseif( $historial == "no"  ) {
            $area->delete();
          
            # TABLE BITACORA
            $this->savedBitacoraTrait( $area, "destroy") ;
          
            $status = true;
            $message = "Registro eliminado de la base de datos";
          }
          
          $data = $area;
          
        }
        else
        {
          $message = "¡El registro no exite o el identificador es incorrecto!";
          $data = $request->all();
        }
      }
      else
      {
        abort(404);
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

      $data = Area::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}