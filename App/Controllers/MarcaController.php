<?php
namespace App\Controllers;

use App\Models\Marca;

class MarcaController {

  public function __construct() {}

  public function getAll()
  {
    try
    {

      $data = Marca::get();

      return $data ;
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }
  }
  
  public function save( $params = array() )
  {
    extract($params) ;
    try
    {
      $id      = null;
      $status  = false;
      $message = "";

      $marca = Marca::where(["nombre" => $nombre])->first();

      if (empty($marca))
      {
        $marca = new Marca();
        $marca->idmarca = $idmarca;
        $marca->nombre = $nombre;
        $marca->publicar = $publicar;
        $marca->estado = $estado;
        $marca->created_up = $created_up;
        
        
        $status = $marca->save();
        
        $id = $marca->id ;
        
        $message = "Operancion Correcta";
        
      }
      else
      {
        $message = "¡El Registro ya existe!";
      }
      $data = ["message" => $message, "status" => $status, "data" => $id,];
    
      return $data;
    
    
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }


}
