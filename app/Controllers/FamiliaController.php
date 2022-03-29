<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando Pisfil
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\Familia; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class FamiliaController
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

      $data = Familia::get();

      return view($this->prefixView.'.familias.list-familias')->with(compact('data'));
    
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

      return view($this->prefixView.'.familias.new-familia');
    
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

      $cod_fam = $request->input('cod_fam');
      $descripcion = $request->input('descripcion');
      $url = $request->input('url');
      $glosa = $request->input('glosa');
      $imagen = $request->file('imagen');
      $publicar = $request->input('publicar');
      $estado = !empty($request->input('estado')) ? $request->input('estado') : 1;

      # STORE
        ##################################################################################
        $path_relative = "images/familias/" ;
        $name_file     = "imagen";
        $image_url     = UploadFiles::uploadFile($request, $name_file , $path_relative);
        $imagen    = $image_url ;
        ##################################################################################

        $familia = new Familia();
        $familia->cod_fam = $cod_fam;
        $familia->descripcion = $descripcion;
        $familia->url = $url;
        $familia->glosa = $glosa;
        $familia->publicar = $publicar;
        $familia->estado = $estado;
        
        $status = $familia->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $familia, "created") ;
        
        
      $message = "Operancion Correcta";
        

      $data = ["message" => $message, "status" => $status, "data" => [$familia],];
    
      return redirect()->route('admin-familias');
    
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

      $familia = Familia::find( $id );

      return view($this->prefixView.'.familias.edit-familia')->with(compact('familia'));
    
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
      $cod_fam = $request->input('cod_fam');
      $descripcion = $request->input('descripcion');
      $url = $request->input('url');
      $glosa = $request->input('glosa');
      $imagen = $request->file('imagen');
      $img_bd     = $request->input('img_bd');
      $publicar = $request->input('publicar');

      if (!empty($id))
      {
        ##################################################################################
        $path_relative = "images/familias/" ;
        $name_file     = "imagen";
        $image_url     = UploadFiles::uploadFile($request, $name_file , $path_relative);
        
        if(empty($image_url))
        {
          $image_url = $img_bd ;
        }
        
        $imagen    = $image_url ;
        ##################################################################################

        $familia = Familia::find($id);
        $familia->id = $id;
        $familia->cod_fam = $cod_fam;
        $familia->descripcion = $descripcion;
        $familia->url = $url;
        $familia->glosa = $glosa;
        $familia->imagen = $imagen;
        $familia->publicar = $publicar;
        
        $status = $familia->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $familia, "update") ;
        
        # remove imagen
        if($imagen != $img_bd && $status )
        {
          if (file_exists($img_bd))
            unlink($img_bd) ;
        }
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-familias');;
    
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

        $familia = Familia::find( $id ) ;

        if (!empty($familia))
        {
          #conservar en base de datos
          if ( $historial == "si" )
          {
            $familia->estado = $estado;
            $familia->save();
              
            # TABLE BITACORA
            $this->savedBitacoraTrait( $familia, "update estado") ;
          
            $status = true;
            //$message = $message;
              
          }elseif( $historial == "no"  ) {
            $familia->delete();
          
            # TABLE BITACORA
            $this->savedBitacoraTrait( $familia, "destroy") ;
          
            $status = true;
            $message = "Registro eliminado de la base de datos";
          }
          
          $data = $familia;
          
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

        $familia = Familia::find($id);
        if (!empty($familia))
        {
          $familia->publicar = $publicar;
          $familia->save();

          # TABLE BITACORA
          $this->savedBitacoraTrait( $familia, "update publicar") ;

          $status = true;
          $message = $message;

         $data = $familia;
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

      $data = Familia::where("publicar", $publicar)->get();

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

      $data = Familia::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}