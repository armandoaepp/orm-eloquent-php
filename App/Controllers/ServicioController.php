<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Servicio; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class ServicioController
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

      $data = Servicio::get();

      return view($this->prefixView.'.servicios.list-servicios')->with(compact('data'));
    
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

      return view($this->prefixView.'.servicios.new-servicio');
    
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

      $ser_descripcion = $request->input('ser_descripcion');
      $ser_icono = $request->input('ser_icono');
      $ser_incluye = $request->input('ser_incluye');
      $ser_no_incluye = $request->input('ser_no_incluye');
      $ser_publicar = $request->input('ser_publicar');
      $ser_estado = !empty($request->input('ser_estado')) ? $request->input('ser_estado') : 1;

      # STORE
        $servicio = new Servicio();
        $servicio->ser_descripcion = $ser_descripcion;
        $servicio->ser_icono = $ser_icono;
        $servicio->ser_incluye = $ser_incluye;
        $servicio->ser_no_incluye = $ser_no_incluye;
        $servicio->ser_publicar = $ser_publicar;
        $servicio->ser_estado = $ser_estado;
        
        $status = $servicio->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $servicio, "created") ;
        
        
      $message = "Operancion Correcta";
        

      $data = ["message" => $message, "status" => $status, "data" => [$servicio],];
    
      return redirect()->route('admin-servicios');
    
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

      $servicio = Servicio::find( $id );

      return view($this->prefixView.'.servicios.edit-servicio')->with(compact('servicio'));
    
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
      $ser_descripcion = $request->input('ser_descripcion');
      $ser_icono = $request->input('ser_icono');
      $ser_incluye = $request->input('ser_incluye');
      $ser_no_incluye = $request->input('ser_no_incluye');
      $ser_publicar = $request->input('ser_publicar');

      if (!empty($id))
      {
        $servicio = Servicio::find($id);
        $servicio->id = $id;
        $servicio->ser_descripcion = $ser_descripcion;
        $servicio->ser_icono = $ser_icono;
        $servicio->ser_incluye = $ser_incluye;
        $servicio->ser_no_incluye = $ser_no_incluye;
        $servicio->ser_publicar = $ser_publicar;
        
        $status = $servicio->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $servicio, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-servicios');;
    
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

        $servicio = Servicio::find( $id ) ;

        if (!empty($servicio))
        {
          #conservar en base de datos
          if ( $historial == "si" )
          {
            $servicio->ser_estado = $estado;
            $servicio->save();
              
            # TABLE BITACORA
            $this->savedBitacoraTrait( $servicio, "update estado") ;
          
            $status = true;
            //$message = $message;
              
          }elseif( $historial == "no"  ) {
            $servicio->delete();
          
            # TABLE BITACORA
            $this->savedBitacoraTrait( $servicio, "destroy") ;
          
            $status = true;
            $message = "Registro eliminado de la base de datos";
          }
          
          $data = $servicio;
          
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

        $servicio = Servicio::find($id);
        if (!empty($servicio))
        {
          $servicio->ser_publicar = $publicar;
          $servicio->save();

          # TABLE BITACORA
          $this->savedBitacoraTrait( $servicio, "update publicar") ;

          $status = true;
          $message = $message;

         $data = $servicio;
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

      $data = Servicio::where("ser_publicar", $ser_publicar)->get();

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

      $data = Servicio::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}