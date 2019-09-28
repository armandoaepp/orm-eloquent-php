<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Adicional; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class AdicionalController
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

      $data = Adicional::get();

      return view($this->prefixView.'.adicionals.list-adicionals')->with(compact('data'));
    
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

      return view($this->prefixView.'.adicionals.new-adicional');
    
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

      $adi_descripcion = $request->input('adi_descripcion');
      $adi_precio = $request->input('adi_precio');
      $adi_publicar = $request->input('adi_publicar');
      $adi_estado = !empty($request->input('adi_estado')) ? $request->input('adi_estado') : 1;

      # STORE
        $adicional = new Adicional();
        $adicional->adi_descripcion = $adi_descripcion;
        $adicional->adi_precio = $adi_precio;
        $adicional->adi_publicar = $adi_publicar;
        $adicional->adi_estado = $adi_estado;
        
        $status = $adicional->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $adicional, "created") ;
        
        
      $message = "Operancion Correcta";
        

      $data = ["message" => $message, "status" => $status, "data" => [$adicional],];
    
      return redirect()->route('admin-adicionals');
    
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

      $adicional = Adicional::find( $id );

      return view($this->prefixView.'.adicionals.edit-adicional')->with(compact('adicional'));
    
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
      $adi_descripcion = $request->input('adi_descripcion');
      $adi_precio = $request->input('adi_precio');
      $adi_publicar = $request->input('adi_publicar');

      if (!empty($id))
      {
        $adicional = Adicional::find($id);
        $adicional->id = $id;
        $adicional->adi_descripcion = $adi_descripcion;
        $adicional->adi_precio = $adi_precio;
        $adicional->adi_publicar = $adi_publicar;
        
        $status = $adicional->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $adicional, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-adicionals');;
    
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

      $adicional = Adicional::find( $id ) ;

      if (!empty($adicional))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $adicional->adi_estado = $estado;
          $adicional->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $adicional, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $adicional->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $adicional, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $adicional;
        
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

  public function updatePublish(Request $request )
  {
    try
    {
      $status  = false;
      $message = "";

      $id = $request->input("id");
      $publicar = $request->input("publicar");

      if (!empty($id))
      {

        if ($publicar == "N") {
          $publicar = "S";
          $message = "Registro Publicado";
        } else {
          $publicar = "N";
          $message = "Registro Ocultado al público";
        }

        $adicional = Adicional::find($id);
        if (!empty($adicional))
        {
          $adicional->adi_publicar = $publicar;
          $adicional->save();

          # TABLE BITACORA
          $this->savedBitacoraTrait( $adicional, "update publicar: ".$publicar) ;

          $status = true;
          $message = $message;

         $data = $adicional;
        }
        else
        {
          $message = "¡El registro no exite o el identificador es incorrecto!";
          $data = $request->all();
        }
        
      }
      else
      {
        $message = "¡El identificador es incorrecto!";
        $data = $request->all();
      }

        return \Response::json([
                "message" => $message,
                "status"  => $status,
                "errors"  => [],
                "data"    => [$data],
              ]);
    
    }
    catch (Exception $e)
    {
        return \Response::json([
                "message" => "Operación fallida en el servidor",
                "status"  => false,
                "errors"  => [$e->getMessage()],
                "data"    => [],
              ]);
    }

  }

  public function getPublished(  $params = array()  )
  {
    try
    {
      extract($params) ;

      $data = Adicional::where("adi_publicar", $adi_publicar)->get();

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function find( $id )
  {
    try
    {

      $data = Adicional::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}