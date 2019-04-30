<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/;

use App\Models\Empresa; 

class EmpresaController
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function getAll()
  {
    try
    {

      $data = Empresa::get();

      return view('admin.empresas.list-empresas')->with(compact('data'));
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function newRegister( Request $request )
  {
    try
    {

      return view('admin.empresas.new-empresa');
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function save( Request $request )
  {
    try
    {
      $status  = false;
      $message = "";

      $empresa_id = $request->input('empresa_id');
      $ruc = $request->input('ruc');
      $razonsocial = $request->input('razonsocial');
      $direccion = $request->input('direccion');
      $telefono = $request->input('telefono');
      $celular = $request->input('celular');
      $paginaweb = $request->input('paginaweb');
      $estado = $request->input('estado');

      $empresa = Empresa::where(["ruc" => $ruc])->first();

      if (empty($empresa))
      {
        $empresa = new Empresa();
        $empresa->empresa_id = $empresa_id;
        $empresa->ruc = $ruc;
        $empresa->razonsocial = $razonsocial;
        $empresa->direccion = $direccion;
        $empresa->telefono = $telefono;
        $empresa->celular = $celular;
        $empresa->paginaweb = $paginaweb;
        $empresa->estado = $estado;
        
        $status = $empresa->save();
        
        $id = $empresa->empresa_id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$empresa],];
    
      return redirect()->route('admin-empresas');
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function edit( $empresa_id )
  {
    try
    {

      $data = Empresa::find($id);

      return view('admin.empresas.edit-empresa')->with(compact('data'));
    
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

      $empresa_id = $request->input('empresa_id');
      $ruc = $request->input('ruc');
      $razonsocial = $request->input('razonsocial');
      $direccion = $request->input('direccion');
      $telefono = $request->input('telefono');
      $celular = $request->input('celular');
      $paginaweb = $request->input('paginaweb');

      if (!empty($empresa_id))
      {
        $empresa = Empresa::find($empresa_id);
        $empresa->empresa_id = $empresa_id;
        $empresa->ruc = $ruc;
        $empresa->razonsocial = $razonsocial;
        $empresa->direccion = $direccion;
        $empresa->telefono = $telefono;
        $empresa->celular = $celular;
        $empresa->paginaweb = $paginaweb;
        
        $status = $empresa->save();
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-empresas');;
    
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

      $empresa = Empresa::find( $empresa_id ) ;

      if (!empty($empresa))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $empresa->estado = $estado;
          $empresa->save();
            
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $empresa->forceDelete();
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
         $data = $plan;
        
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
                "status"  => $status,
                "errors"  => [$e->getMessage(), ],
                "data"    => [],
              ]);
    }

  }

  public function find( $empresa_id )
  {
    try
    {

      $data = Empresa::find($empresa_id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function updateStatus( $params = array() )
  {
    try
    {
      extract($params) ;

      $status  = false;
      $message = "";

      if (empty($empresa_id))
      {
        $empresa = Empresa::find($empresa_id);
        $empresa->estado = $estado;
        
        $status = $empresa->save();
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El identificador es incorrecto!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function getByStatus( $params = array()  )
  {
    try
    {
      extract($params) ;

      $data = Empresa::where("estado", $estado)->get();

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}