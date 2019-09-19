<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Rubro; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class RubroController
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

      $data = Rubro::get();

      return view($this->prefixView.'.rubros.list-rubros')->with(compact('data'));
    
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

      return view($this->prefixView.'.rubros.new-rubro');
    
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

      $rub_descripcion = $request->input('rub_descripcion');
      $rub_codigo = $request->input('rub_codigo');
      $rub_glosa = $request->input('rub_glosa');
      $rub_estado = !empty($request->input('rub_estado')) ? $request->input('rub_estado') : 1;

      $rubro = Rubro::where(["rub_descripcion" => $rub_descripcion])->first();

      if (empty($rubro))
      {

        $rubro = new Rubro();
        $rubro->rub_descripcion = $rub_descripcion;
        $rubro->rub_codigo = $rub_codigo;
        $rubro->rub_glosa = $rub_glosa;
        $rubro->rub_estado = $rub_estado;
        
        $status = $rubro->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $rubro, "created") ;
        
        $id = $rubro->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$rubro],];
    
      return redirect()->route('admin-rubros');
    
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

      $rubro = Rubro::find( $id );

      return view($this->prefixView.'.rubros.edit-rubro')->with(compact('rubro'));
    
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
      $rub_descripcion = $request->input('rub_descripcion');
      $rub_codigo = $request->input('rub_codigo');
      $rub_glosa = $request->input('rub_glosa');

      if (!empty($id))
      {
        $rubro = Rubro::find($id);
        $rubro->id = $id;
        $rubro->rub_descripcion = $rub_descripcion;
        $rubro->rub_codigo = $rub_codigo;
        $rubro->rub_glosa = $rub_glosa;
        
        $status = $rubro->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $rubro, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-rubros');;
    
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

      $rubro = Rubro::find( $id ) ;

      if (!empty($rubro))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $rubro->rub_estado = $estado;
          $rubro->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $rubro, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $rubro->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $rubro, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $rubro;
        
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

      $data = Rubro::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}