<?php
namespace App\Controllers;

/**
  * [Class Controller]
  * Autor: Armando E. Pisfil Puemape
  * twitter: @armandoaepp
  * email: armandoaepp@gmail.com
*/

use App\Models\WbLaResultadosDet; 
use App\Traits\BitacoraTrait;
use App\Traits\UploadFiles;

class WbLaResultadosDetController
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

      $data = WbLaResultadosDet::get();

      return view($this->prefixView.'.wb-la-resultados-dets.list-wb-la-resultados-dets')->with(compact('data'));
    
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

      return view($this->prefixView.'.wb-la-resultados-dets.new-wb-la-resultados-det');
    
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

      $exacod = $request->input('exacod');
      $exades = $request->input('exades');
      $numitm = $request->input('numitm');
      $numprm = $request->input('numprm');
      $codprm = $request->input('codprm');
      $desprm = $request->input('desprm');
      $estprm = $request->input('estprm');
      $obsres = $request->input('obsres');
      $und = $request->input('und');
      $tifprm = $request->input('tifprm');
      $valref = $request->input('valref');
      $valref2 = $request->input('valref2');
      $ran1 = $request->input('ran1');
      $ran2 = $request->input('ran2');
      $resexa_n = $request->input('resexa_n');
      $color = $request->input('color');
      $res = $request->input('res');
      $res2 = $request->input('res2');
      $rentre = $request->input('rentre');
      $estado_wb = $request->input('estado_wb');

      # STORE
        $wb_la_resultados_det = new WbLaResultadosDet();
        $wb_la_resultados_det->exacod = $exacod;
        $wb_la_resultados_det->exades = $exades;
        $wb_la_resultados_det->numitm = $numitm;
        $wb_la_resultados_det->numprm = $numprm;
        $wb_la_resultados_det->codprm = $codprm;
        $wb_la_resultados_det->desprm = $desprm;
        $wb_la_resultados_det->estprm = $estprm;
        $wb_la_resultados_det->obsres = $obsres;
        $wb_la_resultados_det->und = $und;
        $wb_la_resultados_det->tifprm = $tifprm;
        $wb_la_resultados_det->valref = $valref;
        $wb_la_resultados_det->valref2 = $valref2;
        $wb_la_resultados_det->ran1 = $ran1;
        $wb_la_resultados_det->ran2 = $ran2;
        $wb_la_resultados_det->resexa_n = $resexa_n;
        $wb_la_resultados_det->color = $color;
        $wb_la_resultados_det->res = $res;
        $wb_la_resultados_det->res2 = $res2;
        $wb_la_resultados_det->rentre = $rentre;
        $wb_la_resultados_det->estado_wb = $estado_wb;
        
        $status = $wb_la_resultados_det->save();
        
      # TABLE BITACORA
        $this->savedBitacoraTrait( $wb_la_resultados_det, "created") ;
        
        
      $message = "Operancion Correcta";
        

      $data = ["message" => $message, "status" => $status, "data" => [$wb_la_resultados_det],];
    
      return redirect()->route('admin-wb-la-resultados-dets');
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function edit( $invnum )
  {
    try
    {

      $wb_la_resultados_det = WbLaResultadosDet::find( $invnum );

      return view($this->prefixView.'.wb-la-resultados-dets.edit-wb-la-resultados-det')->with(compact('wb_la_resultados_det'));
    
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

      $invnum = $request->input('invnum');
      $exacod = $request->input('exacod');
      $exades = $request->input('exades');
      $numitm = $request->input('numitm');
      $numprm = $request->input('numprm');
      $codprm = $request->input('codprm');
      $desprm = $request->input('desprm');
      $estprm = $request->input('estprm');
      $obsres = $request->input('obsres');
      $und = $request->input('und');
      $tifprm = $request->input('tifprm');
      $valref = $request->input('valref');
      $valref2 = $request->input('valref2');
      $ran1 = $request->input('ran1');
      $ran2 = $request->input('ran2');
      $resexa_n = $request->input('resexa_n');
      $color = $request->input('color');
      $res = $request->input('res');
      $res2 = $request->input('res2');
      $rentre = $request->input('rentre');
      $estado_wb = $request->input('estado_wb');

      if (!empty($invnum))
      {
        $wb_la_resultados_det = WbLaResultadosDet::find($invnum);
        $wb_la_resultados_det->invnum = $invnum;
        $wb_la_resultados_det->exacod = $exacod;
        $wb_la_resultados_det->exades = $exades;
        $wb_la_resultados_det->numitm = $numitm;
        $wb_la_resultados_det->numprm = $numprm;
        $wb_la_resultados_det->codprm = $codprm;
        $wb_la_resultados_det->desprm = $desprm;
        $wb_la_resultados_det->estprm = $estprm;
        $wb_la_resultados_det->obsres = $obsres;
        $wb_la_resultados_det->und = $und;
        $wb_la_resultados_det->tifprm = $tifprm;
        $wb_la_resultados_det->valref = $valref;
        $wb_la_resultados_det->valref2 = $valref2;
        $wb_la_resultados_det->ran1 = $ran1;
        $wb_la_resultados_det->ran2 = $ran2;
        $wb_la_resultados_det->resexa_n = $resexa_n;
        $wb_la_resultados_det->color = $color;
        $wb_la_resultados_det->res = $res;
        $wb_la_resultados_det->res2 = $res2;
        $wb_la_resultados_det->rentre = $rentre;
        $wb_la_resultados_det->estado_wb = $estado_wb;
        
        $status = $wb_la_resultados_det->save();
        
        # TABLE BITACORA
        $this->savedBitacoraTrait( $wb_la_resultados_det, "update") ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];
    
      return redirect()->route('admin-wb-la-resultados-dets');;
    
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

        $wb_la_resultados_det = WbLaResultadosDet::find( $invnum ) ;

        if (!empty($wb_la_resultados_det))
        {
          #conservar en base de datos
          if ( $historial == "si" )
          {
            $wb_la_resultados_det->wlrd_estado = $estado;
            $wb_la_resultados_det->save();
              
            # TABLE BITACORA
            $this->savedBitacoraTrait( $wb_la_resultados_det, "update estado") ;
          
            $status = true;
            //$message = $message;
              
          }elseif( $historial == "no"  ) {
            $wb_la_resultados_det->delete();
          
            # TABLE BITACORA
            $this->savedBitacoraTrait( $wb_la_resultados_det, "destroy") ;
          
            $status = true;
            $message = "Registro eliminado de la base de datos";
          }
          
          $data = $wb_la_resultados_det;
          
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

  public function find( $invnum )
  {
    try
    {

      $data = WbLaResultadosDet::find($invnum);

      return $data;
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }
}