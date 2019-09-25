<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Convenio; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class ConvenioController
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

      $data = Convenio::get();

      return view($this->prefixView.'.convenios.list-convenios')->with(compact('data'));
    
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

      return view($this->prefixView.'.convenios.new-convenio');
    
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

      $tipo_convenio_id = $request->input('tipo_convenio_id');
      $con_nombre = $request->input('con_nombre');
      $con_caracteristica = $request->input('con_caracteristica');
      $con_precio = $request->input('con_precio');
      $con_publicar = $request->input('con_publicar');
      $con_estado = !empty($request->input('con_estado')) ? $request->input('con_estado') : 1;

      $convenio = Convenio::where(["tipo_convenio_id" => $tipo_convenio_id])->first();

      if (empty($convenio))
      {

        $convenio = new Convenio();
        $convenio->tipo_convenio_id = $tipo_convenio_id;
        $convenio->con_nombre = $con_nombre;
        $convenio->con_caracteristica = $con_caracteristica;
        $convenio->con_precio = $con_precio;
        $convenio->con_publicar = $con_publicar;
        $convenio->con_estado = $con_estado;
        
        $status = $convenio->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $convenio, "created") ;
        
        $id = $convenio->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$convenio],];
    
      return redirect()->route('admin-convenios');
    
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

      $convenio = Convenio::find( $id );

      return view($this->prefixView.'.convenios.edit-convenio')->with(compact('convenio'));
    
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
      $tipo_convenio_id = $request->input('tipo_convenio_id');
      $con_nombre = $request->input('con_nombre');
      $con_caracteristica = $request->input('con_caracteristica');
      $con_precio = $request->input('con_precio');
      $con_publicar = $request->input('con_publicar');

      if (!empty($id))
      {
        $convenio = Convenio::find($id);
        $convenio->id = $id;
        $convenio->tipo_convenio_id = $tipo_convenio_id;
        $convenio->con_nombre = $con_nombre;
        $convenio->con_caracteristica = $con_caracteristica;
        $convenio->con_precio = $con_precio;
        $convenio->con_publicar = $con_publicar;
        
        $status = $convenio->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $convenio, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-convenios');;
    
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

      $convenio = Convenio::find( $id ) ;

      if (!empty($convenio))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $convenio->con_estado = $estado;
          $convenio->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $convenio, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $convenio->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $convenio, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $convenio;
        
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

        $convenio = Convenio::find($id);
        if (!empty($convenio))
        {
          $convenio->con_publicar = $publicar;
          $convenio->save();

          # TABLE BITACORA
          $this->savedBitacoraTrait( $convenio, "update publicar: ".$publicar) ;

          $status = true;
          $message = $message;

         $data = $convenio;
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

      $data = Convenio::where("con_publicar", $con_publicar)->get();

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

      $data = Convenio::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}