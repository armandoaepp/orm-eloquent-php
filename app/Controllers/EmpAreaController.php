<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\EmpArea; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class EmpAreaController
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

      $data = EmpArea::get();

      return view($this->prefixView.'.emp-areas.list-emp-areas')->with(compact('data'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function listTable(Request $request)
  {
    try
    {

      $data = EmpArea::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.emp-areas.list-emp-areas')->with(compact('data'));
    
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
        return view($this->prefixView.'.emp-areas.form-create-emp-area');
      }

      return view($this->prefixView.'.emp-areas.new-emp-area');
    
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
        $emp_area = new EmpArea();
        $emp_area->area_id_sup = $area_id_sup;
        $emp_area->descripcion = $descripcion;
        $emp_area->grupo_id = $grupo_id;
        $emp_area->nivel = $nivel;
        $emp_area->estado = $estado;
        
        $status = $emp_area->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $emp_area, "created") ;
        
        
      $message = "Operancion Correcta";
        

      $data = ["message" => $message, "status" => $status, "data" => [$emp_area],];
    
      return redirect()->route('admin-emp-areas');
    
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

      $emp_area = EmpArea::find( $id );

      return view($this->prefixView.'.emp-areas.edit-emp-area')->with(compact('emp_area'));
    
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
        $emp_area = EmpArea::find($id);
        $emp_area->id = $id;
        $emp_area->area_id_sup = $area_id_sup;
        $emp_area->descripcion = $descripcion;
        $emp_area->grupo_id = $grupo_id;
        $emp_area->nivel = $nivel;
        
        $status = $emp_area->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $emp_area, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-emp-areas');;
    
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

        $emp_area = EmpArea::find( $id ) ;

        if (!empty($emp_area))
        {
          #conservar en base de datos
          if ( $historial == "si" )
          {
            $emp_area->estado = $estado;
            $emp_area->save();
              
            # TABLE BITACORA
            $this->savedBitacoraTrait( $emp_area, "update estado") ;
          
            $status = true;
            //$message = $message;
              
          }elseif( $historial == "no"  ) {
            $emp_area->delete();
          
            # TABLE BITACORA
            $this->savedBitacoraTrait( $emp_area, "destroy") ;
          
            $status = true;
            $message = "Registro eliminado de la base de datos";
          }
          
          $data = $emp_area;
          
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

      $data = EmpArea::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}