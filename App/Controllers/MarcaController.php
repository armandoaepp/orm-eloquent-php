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
      $id      = null ;
      $status  = false;
      $message = "";

      $marca = Marca::where(["nombre" => $nombre])->first();

      if (empty($marca))
      {
        $marca = new Marca();

        $marca->nombre   = $nombre;
        $marca->url      = $url;
        $marca->imagen   = $imagen;
        $marca->publicar = $publicar;

        $status = $marca->save();

        $id = $marca->id ;

        $message = "Operancion Correcta";

      } else {
        $message = "¡El Pais Ya existe!";
      }

      $data = [
              "message" => $message,
              "status"  => $status,
              "data"    => $id,
            ];

      return $data ;
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }
  }


}
