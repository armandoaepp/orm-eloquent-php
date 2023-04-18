<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Paciente; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PacienteController
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

      $data = Paciente::get();

      return view($this->prefixView.'.pacientes.list-pacientes')->with(compact('data'));
    
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

      $data = Paciente::orderBy('id', 'desc')->get();

      return view($this->prefixView.'.pacientes.list-table-pacientes')->with(compact('data'));
    
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
        return view($this->prefixView.'.pacientes.form-create-paciente');
      }

      return view($this->prefixView.'.pacientes.new-paciente');
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function store(PacienteStoreRequest $request )
  {
    try
    {
      $success = false;
      $message = "";

      $sede_id = $request->input('sede_id');
      $persona_id = $request->input('persona_id');
      $codigo = $request->input('codigo');
      $num_doc = $request->input('num_doc');
      $apellidos = $request->input('apellidos');
      $nombres = $request->input('nombres');
      $telefono = $request->input('telefono');
      $direccion = $request->input('direccion');
      $sexo = $request->input('sexo');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        $paciente = new Paciente();
        $paciente->sede_id = $sede_id;
        $paciente->persona_id = $persona_id;
        $paciente->codigo = $codigo;
        $paciente->num_doc = $num_doc;
        $paciente->apellidos = $apellidos;
        $paciente->nombres = $nombres;
        $paciente->telefono = $telefono;
        $paciente->direccion = $direccion;
        $paciente->sexo = $sexo;
        $paciente->estado = $estado;
        
        $success = $paciente->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $paciente, "created") ;
        
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
    
      return redirect()->route('admin.pacientes');
    
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

      $paciente = Paciente::find( $id );

      if ($request->ajax()) {
        return view($this->prefixView .'.pacientes.form-edit-paciente')->with(compact('paciente'));
      }

      return view($this->prefixView.'.pacientes.edit-paciente')->with(compact('paciente'));
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }

  public function update(PacienteUpdateRequest $request )
  {
    try
    {

      $success = false;
      $message = "";

      $id = $request->input('id');
      $sede_id = $request->input('sede_id');
      $persona_id = $request->input('persona_id');
      $codigo = $request->input('codigo');
      $num_doc = $request->input('num_doc');
      $apellidos = $request->input('apellidos');
      $nombres = $request->input('nombres');
      $telefono = $request->input('telefono');
      $direccion = $request->input('direccion');
      $sexo = $request->input('sexo');

      if (!empty($id))
      {
        $paciente = Paciente::find($id);

        # For Bitacora Atributos Old;
        $attributes_old = $paciente->getAttributes();

        $paciente->id = $id;
        $paciente->sede_id = $sede_id;
        $paciente->persona_id = $persona_id;
        $paciente->codigo = $codigo;
        $paciente->num_doc = $num_doc;
        $paciente->apellidos = $apellidos;
        $paciente->nombres = $nombres;
        $paciente->telefono = $telefono;
        $paciente->direccion = $direccion;
        $paciente->sexo = $sexo;
        
        $success = $paciente->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $paciente, "update", $attributes_old) ;
        
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

      return redirect()->route('admin.pacientes');
    
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

      $paciente = Paciente::find( $id ) ;

      if (!empty($paciente))
      {

        # For Bitacora Atributos Old;
        $attributes_old = $paciente->getAttributes();

        $paciente->estado = $estado;
        $paciente->save();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $paciente, "update estado", $attributes_old) ;
        
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

      $paciente = Paciente::find( $id ) ;

      if (!empty($paciente))
      {

        $paciente->delete();

        # TABLE BITACORA
        $this->savedBitacoraTrait( $paciente, "destroy") ;
        
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

      $data = Paciente::find($id);

      return $data;
    
    }
    catch (\Exception $e)
    {
      throw new \Exception($e->getMessage());
    }

  }
}