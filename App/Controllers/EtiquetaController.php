<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Etiqueta; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class EtiquetaController
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

      $data = Etiqueta::get();

      return view($this->prefixView.'.etiquetas.list-etiquetas')->with(compact('data'));
    
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

      return view($this->prefixView.'.etiquetas.new-etiqueta');
    
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

      $eti_descripcion = $request->input('eti_descripcion');
      $eti_publicar = $request->input('eti_publicar');
      $eti_estado = $request->input('eti_estado');

      $etiqueta = Etiqueta::where(["eti_descripcion" => $eti_descripcion])->first();

      if (empty($etiqueta))
      {

        $etiqueta = new Etiqueta();
        $etiqueta->eti_descripcion = $eti_descripcion;
        $etiqueta->eti_publicar = $eti_publicar;
        $etiqueta->eti_estado = $eti_estado;
        
        $status = $etiqueta->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $etiqueta, "created") ;
        
        $id = $etiqueta->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$etiqueta],];
    
      return redirect()->route('admin-etiquetas');
    
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

      $etiqueta = Etiqueta::find( $id );

      return view($this->prefixView.'.etiquetas.edit-etiqueta')->with(compact('etiqueta'));
    
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
      $eti_descripcion = $request->input('eti_descripcion');
      $eti_publicar = $request->input('eti_publicar');

      if (!empty($id))
      {
        $etiqueta = Etiqueta::find($id);
        $etiqueta->id = $id;
        $etiqueta->eti_descripcion = $eti_descripcion;
        $etiqueta->eti_publicar = $eti_publicar;
        
        $status = $etiqueta->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $etiqueta, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-etiquetas');;
    
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

      $etiqueta = Etiqueta::find( $id ) ;

      if (!empty($etiqueta))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $etiqueta->eti_estado = $estado;
          $etiqueta->save();
            
        # TABLE BITACORA
        $this->savedBitacoraTrait( $etiqueta, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $etiqueta->forceDelete();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $etiqueta, "delete registro") ;
        
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
                "status"  => false,
                "errors"  => [$e->getMessage(), ],
                "data"    => [],
              ]);
    }

  }

  public function updatePublish( Request $request )
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

        $etiqueta = Etiqueta::find($id);
        if ($etiqueta)
        {
          $etiqueta->eti_publicar = $publicar;
          $etiqueta->save();

          # TABLE BITACORA
          $this->savedBitacoraTrait( $etiqueta, "update publicar: ".$publicar) ;

          $status = true;
         $message = $message;

         $data = $categoria;
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

      $data = Etiqueta::where("eti_publicar", $eti_publicar)->get();

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

      $data = Etiqueta::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}