<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\PerImagen; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PerImagenController
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

      $data = PerImagen::get();

      return view($this->prefixView.'.per-imagens.list-per-imagens')->with(compact('data'));
    
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

      return view($this->prefixView.'.per-imagens.new-per-imagen');
    
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

      $persona_id = $request->input('persona_id');
      $pi_imagen = $request->file('pi_imagen');
      $pi_estado = !empty($request->input('pi_estado')) ? $request->input('pi_estado') : 1;

      $per_imagen = PerImagen::where(["persona_id" => $persona_id])->first();

      if (empty($per_imagen))
      {

        ##################################################################################
        $path_relative = "images/per_imagens/" ;
        $name_file     = "pi_imagen";
        $image_url     = UploadFiles::uploadFile($request, $name_file , $path_relative);
        $pi_imagen    = $image_url ;
        ##################################################################################

        $per_imagen = new PerImagen();
        $per_imagen->persona_id = $persona_id;
        $per_imagen->pi_imagen = $pi_imagen;
        $per_imagen->pi_estado = $pi_estado;
        
        $status = $per_imagen->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $per_imagen, "created") ;
        
        $id = $per_imagen->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$per_imagen],];
    
      return redirect()->route('admin-per-imagens');
    
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

      $per_imagen = PerImagen::find( $id );

      return view($this->prefixView.'.per-imagens.edit-per-imagen')->with(compact('per_imagen'));
    
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
      $persona_id = $request->input('persona_id');
      $pi_imagen = $request->file('pi_imagen');
      $img_bd     = $request->input('img_bd');

      if (!empty($id))
      {
        ##################################################################################
        $path_relative = "images/per_imagens/" ;
        $name_file     = "pi_imagen";
        $image_url     = UploadFiles::uploadFile($request, $name_file , $path_relative);
        
        if(empty($image_url))
        {
          $image_url = $img_bd ;
        }
        
        $pi_imagen    = $image_url ;
        ##################################################################################

        $per_imagen = PerImagen::find($id);
        $per_imagen->id = $id;
        $per_imagen->persona_id = $persona_id;
        $per_imagen->pi_imagen = $pi_imagen;
        
        $status = $per_imagen->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $per_imagen, "update") ;
        
        # remove imagen
        if($pi_imagen != $img_bd && $status )
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
    
      return redirect()->route('admin-per-imagens');;
    
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

      $per_imagen = PerImagen::find( $id ) ;

      if (!empty($per_imagen))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $per_imagen->pi_estado = $estado;
          $per_imagen->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $per_imagen, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $per_imagen->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $per_imagen, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $per_imagen;
        
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

      $data = PerImagen::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}