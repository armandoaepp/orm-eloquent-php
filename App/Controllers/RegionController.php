<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Region; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class RegionController
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

      $data = Region::get();

      return view($this->prefixView.'.regions.list-regions')->with(compact('data'));
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function create(Request $request )
  {
    try
    {

      return view($this->prefixView.'.regions.new-region');
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function store(Request $request )
  {
    try
    {
      $status  = false;
      $message = "";

      $reg_nombre = $request->input('reg_nombre');
      $reg_estado = !empty($request->input('reg_estado')) ? $request->input('reg_estado') : 1;

      # STORE
        $region = new Region();
        $region->reg_nombre = $reg_nombre;
        $region->reg_estado = $reg_estado;
        
        $status = $region->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $region, "created") ;
        
        
      $message = "Operancion Correcta";
        

      $data = ["message" => $message, "status" => $status, "data" => [$region],];
    
      return redirect()->route('admin-regions');
    
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

      $region = Region::find( $id );

      return view($this->prefixView.'.regions.edit-region')->with(compact('region'));
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function update(Request $request )
  {
    try
    {

      $status  = false;
      $message = "";

      $id = $request->input('id');
      $reg_nombre = $request->input('reg_nombre');

      if (!empty($id))
      {
        $region = Region::find($id);
        $region->id = $id;
        $region->reg_nombre = $reg_nombre;
        
        $status = $region->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $region, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-regions');;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
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

      $status  = false;
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

        $region = Region::find( $id ) ;

        if (!empty($region))
        {
          #conservar en base de datos
          if ( $historial == "si" )
          {
            $region->reg_estado = $estado;
            $region->save();
              
            # TABLE BITACORA
            $this->savedBitacoraTrait( $region, "update estado") ;
          
            $status = true;
            //$message = $message;
              
          }elseif( $historial == "no"  ) {
            $region->delete();
          
            # TABLE BITACORA
            $this->savedBitacoraTrait( $region, "destroy") ;
          
            $status = true;
            $message = "Registro eliminado de la base de datos";
          }
          
          $data = $region;
          
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

      $data = Region::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}