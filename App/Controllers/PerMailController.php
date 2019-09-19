<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\PerMail; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class PerMailController
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

      $data = PerMail::get();

      return view($this->prefixView.'.per-mails.list-per-mails')->with(compact('data'));
    
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

      return view($this->prefixView.'.per-mails.new-per-mail');
    
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
      $pm_jerarquia = $request->input('pm_jerarquia');
      $pm_mail = $request->input('pm_mail');
      $pm_estado = !empty($request->input('pm_estado')) ? $request->input('pm_estado') : 1;

      $per_mail = PerMail::where(["persona_id" => $persona_id])->first();

      if (empty($per_mail))
      {

        $per_mail = new PerMail();
        $per_mail->persona_id = $persona_id;
        $per_mail->pm_jerarquia = $pm_jerarquia;
        $per_mail->pm_mail = $pm_mail;
        $per_mail->pm_estado = $pm_estado;
        
        $status = $per_mail->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $per_mail, "created") ;
        
        $id = $per_mail->id;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => [$per_mail],];
    
      return redirect()->route('admin-per-mails');
    
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

      $per_mail = PerMail::find( $id );

      return view($this->prefixView.'.per-mails.edit-per-mail')->with(compact('per_mail'));
    
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
      $pm_jerarquia = $request->input('pm_jerarquia');
      $pm_mail = $request->input('pm_mail');

      if (!empty($id))
      {
        $per_mail = PerMail::find($id);
        $per_mail->id = $id;
        $per_mail->persona_id = $persona_id;
        $per_mail->pm_jerarquia = $pm_jerarquia;
        $per_mail->pm_mail = $pm_mail;
        
        $status = $per_mail->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $per_mail, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-per-mails');;
    
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

      $per_mail = PerMail::find( $id ) ;

      if (!empty($per_mail))
      {
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $per_mail->pm_estado = $estado;
          $per_mail->save();
            
          # TABLE BITACORA
          $this->savedBitacoraTrait( $per_mail, "update estado: ".$estado) ;
        
          $status = true;
          $message = "Registro Eliminado";
            
        }elseif( $historial == "no"  ) {
          $per_mail->forceDelete();
        
          # TABLE BITACORA
          $this->savedBitacoraTrait( $per_mail, "delete registro") ;
        
          $status = true;
          $message = "Registro eliminado de la base de datos";
        }
        
        $data = $per_mail;
        
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

      $data = PerMail::find($id);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}