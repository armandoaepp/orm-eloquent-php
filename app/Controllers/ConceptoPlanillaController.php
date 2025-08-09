<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\ConceptoPlanilla; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class ConceptoPlanillaController
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

      $data = ConceptoPlanilla::get();

      return view($this->prefixView.'.concepto-planillas.list-concepto-planillas')->with(compact('data'));
    
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

      $data = ConceptoPlanilla::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.concepto-planillas.list-table-concepto-planillas')->with(compact('data'));
    
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
        return view($this->prefixView.'.concepto-planillas.form-create-concepto-planilla');
      }

      return view($this->prefixView.'.concepto-planillas.new-concepto-planilla');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(ConceptoPlanillaStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $empleado_id = $request->input('empleado_id');
      $periodo_id = $request->input('periodo_id');
      $tipo_concepto_id = $request->input('tipo_concepto_id');
      $fecha = $request->input('fecha');
      $monto = $request->input('monto');
      $descripcion = $request->input('descripcion');
      $estado_pagado = $request->input('estado_pagado');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $concepto_planilla = new ConceptoPlanilla();
        $concepto_planilla->empleado_id = $empleado_id;
        $concepto_planilla->periodo_id = $periodo_id;
        $concepto_planilla->tipo_concepto_id = $tipo_concepto_id;
        $concepto_planilla->fecha = $fecha;
        $concepto_planilla->monto = $monto;
        $concepto_planilla->descripcion = $descripcion;
        $concepto_planilla->estado_pagado = $estado_pagado;
        $concepto_planilla->estado = $estado;
        
        $success = $concepto_planilla->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $concepto_planilla, "created") ;
        
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
    
      return redirect()->route('admin.concepto-planillas');
    
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

      $concepto_planilla = ConceptoPlanilla::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.concepto-planillas.form-edit-concepto-planilla')->with(compact('concepto_planilla'));
      }

      return view($this->prefixView.'.concepto-planillas.edit-concepto-planilla')->with(compact('concepto_planilla'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function update(ConceptoPlanillaUpdateRequest $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id = $request->input('id');
      $empleado_id = $request->input('empleado_id');
      $periodo_id = $request->input('periodo_id');
      $tipo_concepto_id = $request->input('tipo_concepto_id');
      $fecha = $request->input('fecha');
      $monto = $request->input('monto');
      $descripcion = $request->input('descripcion');
      $estado_pagado = $request->input('estado_pagado');

      if (!empty($id))
      {
        $concepto_planilla = ConceptoPlanilla::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $concepto_planilla->getAttributes();

        $concepto_planilla->id = $id;
        $concepto_planilla->empleado_id = $empleado_id;
        $concepto_planilla->periodo_id = $periodo_id;
        $concepto_planilla->tipo_concepto_id = $tipo_concepto_id;
        $concepto_planilla->fecha = $fecha;
        $concepto_planilla->monto = $monto;
        $concepto_planilla->descripcion = $descripcion;
        $concepto_planilla->estado_pagado = $estado_pagado;
        
        $success = $concepto_planilla->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $concepto_planilla, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.concepto-planillas');
    
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

      $concepto_planilla = ConceptoPlanilla::find( $id ) ;

      if (!empty($concepto_planilla))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $concepto_planilla->getAttributes();

        $concepto_planilla->estado = $estado;
        $concepto_planilla->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $concepto_planilla, "update estado", $attributes_old) ;
        
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

      $concepto_planilla = ConceptoPlanilla::find( $id ) ;

      if (!empty($concepto_planilla))
      {

        $concepto_planilla->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $concepto_planilla, "destroy") ;
        
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

      $data = ConceptoPlanilla::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}