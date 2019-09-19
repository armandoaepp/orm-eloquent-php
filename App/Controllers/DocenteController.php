<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Docente; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class DocenteController
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

      $data = Docente::get();

      return view($this->prefixView.'.docentes.list-docentes')->with(compact('data'));
    
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

      return view($this->prefixView.'.docentes.new-docente');
    
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

      $per_id_padre = $request->input('per_id_padre');
      $persona_id = $request->input('persona_id');
      $doc_codigo = $request->input('doc_codigo');
      $doc_estado = !empty($request->input('doc_estado')) ? $request->input('doc_estado') : 1;

      $docente = Docente::where(["per_id_padre" => $per_id_padre])->first();

      if (empty($docente))
      {

        $docente = new Docente();
        $docente->per_id_padre = $per_id_padre;
        $docente->persona_id = $persona_id;
        $docente->doc_codigo = $doc_codigo;
        $docente->doc_estado = $doc_estado;
        
        $status = $docente->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $docente, "created") ;
        
        $id = $docente->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$docente],];
    
      return redirect()->route('admin-docentes');
    
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

      $docente = Docente::find( $id );

      return view($this->prefixView.'.docentes.edit-docente')->with(compact('docente'));
    
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
      $per_id_padre = $request->input('per_id_padre');
      $persona_id = $request->input('persona_id');
      $doc_codigo = $request->input('doc_codigo');

      if (!empty($id))
      {
        $docente = Docente::find($id);
        $docente->id = $id;
        $docente->per_id_padre = $per_id_padre;
        $docente->persona_id = $persona_id;
        $docente->doc_codigo = $doc_codigo;
        
        $status = $docente->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $docente, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-docentes');;
    
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

      $docente = Docente::find( $id ) ;

      if (!empty($docente))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $docente->doc_estado = $estado;
          $docente->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $docente, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $docente->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $docente, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $docente;
        
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

      $data = Docente::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}