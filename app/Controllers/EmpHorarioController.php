<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\EmpHorario; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class EmpHorarioController
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

      $data = EmpHorario::get();

      return view($this->prefixView.'.emp-horarios.list-emp-horarios')->with(compact('data'));
    
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

      $data = EmpHorario::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.emp-horarios.list-table-emp-horarios')->with(compact('data'));
    
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
        return view($this->prefixView.'.emp-horarios.form-create-emp-horario');
      }

      return view($this->prefixView.'.emp-horarios.new-emp-horario');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(EmpHorarioStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $area_id = $request->input('area_id');
      $tipo_jordana_id = $request->input('tipo_jordana_id');
      $descripcion = $request->input('descripcion');
      $ingreso = $request->input('ingreso');
      $salida = $request->input('salida');
      $ingreso2 = $request->input('ingreso2');
      $salida2 = $request->input('salida2');
      $ingreso3 = $request->input('ingreso3');
      $salida3 = $request->input('salida3');
      $duracion = $request->input('duracion');
      $is_continuo = $request->input('is_continuo');
      $dia_siguiente = $request->input('dia_siguiente');
      $ing_tol_antes = $request->input('ing_tol_antes');
      $ing_tol_despues = $request->input('ing_tol_despues');
      $sal_tol_antes = $request->input('sal_tol_antes');
      $sal_tol_despues = $request->input('sal_tol_despues');
      $is_tol_ajustar = $request->input('is_tol_ajustar');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $emp_horario = new EmpHorario();
        $emp_horario->area_id = $area_id;
        $emp_horario->tipo_jordana_id = $tipo_jordana_id;
        $emp_horario->descripcion = $descripcion;
        $emp_horario->ingreso = $ingreso;
        $emp_horario->salida = $salida;
        $emp_horario->ingreso2 = $ingreso2;
        $emp_horario->salida2 = $salida2;
        $emp_horario->ingreso3 = $ingreso3;
        $emp_horario->salida3 = $salida3;
        $emp_horario->duracion = $duracion;
        $emp_horario->is_continuo = $is_continuo;
        $emp_horario->dia_siguiente = $dia_siguiente;
        $emp_horario->ing_tol_antes = $ing_tol_antes;
        $emp_horario->ing_tol_despues = $ing_tol_despues;
        $emp_horario->sal_tol_antes = $sal_tol_antes;
        $emp_horario->sal_tol_despues = $sal_tol_despues;
        $emp_horario->is_tol_ajustar = $is_tol_ajustar;
        $emp_horario->estado = $estado;
        
        $success = $emp_horario->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $emp_horario, "created") ;
        
      $message = "Datos Registrados Correctamente";
        
      if ($request->ajax()) {
        return response()->json([
          "message" => $message,
          "code"    => 200,
          "success"  => $success,
          "errors"  => [],
          "data"    => [],
        ]);
      };
    
      return redirect()->route('admin.emp-horarios');
    
    }
    catch (\Exception $e)
    {

      if ($request->ajax()) {
        return response()->json([
          "message" => "Operación fallida en el servidor",
          "code"    => 500,
          "success"  => false,
          "errors"  => [$e->getMessage()],
          "data"    => []
        ]);
      }

      throw new \Exception($e->getMessage());
    }

  }

  public function edit( $id, Request $request)
  {
    try
    {

      $emp_horario = EmpHorario::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.emp-horarios.form-edit-emp-horario')->with(compact('emp_horario'));
      }

      return view($this->prefixView.'.emp-horarios.edit-emp-horario')->with(compact('emp_horario'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function update(EmpHorarioUpdateRequest $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id = $request->input('id');
      $area_id = $request->input('area_id');
      $tipo_jordana_id = $request->input('tipo_jordana_id');
      $descripcion = $request->input('descripcion');
      $ingreso = $request->input('ingreso');
      $salida = $request->input('salida');
      $ingreso2 = $request->input('ingreso2');
      $salida2 = $request->input('salida2');
      $ingreso3 = $request->input('ingreso3');
      $salida3 = $request->input('salida3');
      $duracion = $request->input('duracion');
      $is_continuo = $request->input('is_continuo');
      $dia_siguiente = $request->input('dia_siguiente');
      $ing_tol_antes = $request->input('ing_tol_antes');
      $ing_tol_despues = $request->input('ing_tol_despues');
      $sal_tol_antes = $request->input('sal_tol_antes');
      $sal_tol_despues = $request->input('sal_tol_despues');
      $is_tol_ajustar = $request->input('is_tol_ajustar');

      if (!empty($id))
      {
        $emp_horario = EmpHorario::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $emp_horario->getAttributes();

        $emp_horario->id = $id;
        $emp_horario->area_id = $area_id;
        $emp_horario->tipo_jordana_id = $tipo_jordana_id;
        $emp_horario->descripcion = $descripcion;
        $emp_horario->ingreso = $ingreso;
        $emp_horario->salida = $salida;
        $emp_horario->ingreso2 = $ingreso2;
        $emp_horario->salida2 = $salida2;
        $emp_horario->ingreso3 = $ingreso3;
        $emp_horario->salida3 = $salida3;
        $emp_horario->duracion = $duracion;
        $emp_horario->is_continuo = $is_continuo;
        $emp_horario->dia_siguiente = $dia_siguiente;
        $emp_horario->ing_tol_antes = $ing_tol_antes;
        $emp_horario->ing_tol_despues = $ing_tol_despues;
        $emp_horario->sal_tol_antes = $sal_tol_antes;
        $emp_horario->sal_tol_despues = $sal_tol_despues;
        $emp_horario->is_tol_ajustar = $is_tol_ajustar;
        
        $success = $emp_horario->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $emp_horario, "update", $attributes_old) ;
        
        $message = "Datos Actualizados Correctamente";
        $code = 200;
        
      }
      else
      {
        $message = "¡El registro NO existe!";
        $code = 406;
      }

      if ($request->ajax()) {
        return response()->json([
          "message" => $message,
          "code"    => $code,
          "success"  => $success,
          "errors"  => [],
          "data"    => [],
        ]);
      };

      return redirect()->route('admin.emp-horarios');
    
    }
    catch (\Exception $e)
    {

      if ($request->ajax()) {
        return response()->json([
          "message" => "Operación fallida en el servidor",
          "code"    => 500,
          "success" => false,
          "errors"  => [$e->getMessage()],
          "data"    => []
        ]);
      }

      throw new \Exception($e->getMessage());
    }

  }

  public function delete(EstadoIdRequest $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id        = $request->input('id');
      $estado    = $request->input('estado');

      if ($estado == 1) {
        $message = "Registro Activado Correctamente";
      } else {
        $message = "Registro Desactivo Correctamente";
      }

      $emp_horario = EmpHorario::find( $id ) ;

      if (!empty($emp_horario))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $emp_horario->getAttributes();

        $emp_horario->estado = $estado;
        $emp_horario->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $emp_horario, "update estado", $attributes_old) ;
        
        $success = true;
        $code = 200;
      } else {
        $message = "¡El registro no exite o el identificador es incorrecto!";
        $success  = false;
        $code = 400;
      }  
        
      if ($request->ajax()) {
        return response()->json([
          "message" => $message,
          "code"    => $code,
          "success" => $success,
          "errors"  => [],
          "data"    => [],
        ]);
      };
        
    }
    catch (\Throwable $e) 
    {

      if ($request->ajax()) {
        return response()->json([
          "message" => "Operación fallida en el servidor",
          "code"    => 500,
          "success"  => false,
          "errors"  => [$e->getMessage()],
          "data"    => []
        ]);
      }

      throw new \Exception($e->getMessage());
    }

  }

  public function destroy(Request $request )
  {
    try
    {
      $validator = \Validator::make($request->all(), [
        'id'     => 'numeric',
      ]);
      if ($validator->fails())
      {
        if ($request->ajax())
        {
          return response()->json([
            "message" => "Error al realizar operación",
            "code"    => 400,
            "success" => false,
            "errors"  => $validator->errors()->all(),
            "data"    => [],
            ]);
        }
      }


      $success = false;
      $message = "";

      $id = $request->input('id');

      $emp_horario = EmpHorario::find( $id ) ;

      if (!empty($emp_horario))
      {

        $emp_horario->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $emp_horario, "destroy") ;
        
        $success = true;
        $code = 200;
        $message = "Registro Borrado Correctamente";
      } else {
        $message = "¡El registro no exite o el identificador es incorrecto!";
        $success  = false;
        $code = 400;
      }  
        
      if ($request->ajax()) {
        return response()->json([
          "message" => $message,
          "code"    => $code,
          "success" => $success,
          "errors"  => [],
          "data"    => [],
        ]);
      }
        
    }
    catch (\Throwable $e) 
    {

      if ($request->ajax()) {
        return response()->json([
          "message" => "Operación fallida en el servidor",
          "code"    => 500,
          "success" => false,
          "errors"  => [$e->getMessage()],
          "data"    => []
        ]);
      }

      throw new \Exception($e->getMessage());
    }

  }

  public function find( $id )
  {
    try
    {

      $data = EmpHorario::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}