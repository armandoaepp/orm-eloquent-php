<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Horario; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class HorarioController
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

      $data = Horario::get();

      return view($this->prefixView.'.horarios.list-horarios')->with(compact('data'));
    
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

      $data = Horario::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.horarios.list-table-horarios')->with(compact('data'));
    
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
        return view($this->prefixView.'.horarios.form-create-horario');
      }

      return view($this->prefixView.'.horarios.new-horario');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(HorarioStoreRequest $request )
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
        $horario = new Horario();
        $horario->area_id = $area_id;
        $horario->tipo_jordana_id = $tipo_jordana_id;
        $horario->descripcion = $descripcion;
        $horario->ingreso = $ingreso;
        $horario->salida = $salida;
        $horario->ingreso2 = $ingreso2;
        $horario->salida2 = $salida2;
        $horario->ingreso3 = $ingreso3;
        $horario->salida3 = $salida3;
        $horario->duracion = $duracion;
        $horario->is_continuo = $is_continuo;
        $horario->dia_siguiente = $dia_siguiente;
        $horario->ing_tol_antes = $ing_tol_antes;
        $horario->ing_tol_despues = $ing_tol_despues;
        $horario->sal_tol_antes = $sal_tol_antes;
        $horario->sal_tol_despues = $sal_tol_despues;
        $horario->is_tol_ajustar = $is_tol_ajustar;
        $horario->estado = $estado;
        
        $success = $horario->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $horario, "created") ;
        
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
    
      return redirect()->route('admin.horarios');
    
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

      $horario = Horario::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.horarios.form-edit-horario')->with(compact('horario'));
      }

      return view($this->prefixView.'.horarios.edit-horario')->with(compact('horario'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function update(HorarioUpdateRequest $request )
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
        $horario = Horario::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $horario->getAttributes();

        $horario->id = $id;
        $horario->area_id = $area_id;
        $horario->tipo_jordana_id = $tipo_jordana_id;
        $horario->descripcion = $descripcion;
        $horario->ingreso = $ingreso;
        $horario->salida = $salida;
        $horario->ingreso2 = $ingreso2;
        $horario->salida2 = $salida2;
        $horario->ingreso3 = $ingreso3;
        $horario->salida3 = $salida3;
        $horario->duracion = $duracion;
        $horario->is_continuo = $is_continuo;
        $horario->dia_siguiente = $dia_siguiente;
        $horario->ing_tol_antes = $ing_tol_antes;
        $horario->ing_tol_despues = $ing_tol_despues;
        $horario->sal_tol_antes = $sal_tol_antes;
        $horario->sal_tol_despues = $sal_tol_despues;
        $horario->is_tol_ajustar = $is_tol_ajustar;
        
        $success = $horario->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $horario, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.horarios');
    
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

      $horario = Horario::find( $id ) ;

      if (!empty($horario))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $horario->getAttributes();

        $horario->estado = $estado;
        $horario->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $horario, "update estado", $attributes_old) ;
        
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

      $horario = Horario::find( $id ) ;

      if (!empty($horario))
      {

        $horario->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $horario, "destroy") ;
        
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

      $data = Horario::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}