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
        $marca->publish = $publish;
        $marca->estado = $estado;

        $status = $marca->save();

        $id = $marca->idmarca;

        $message = "Operancion Correcta";

      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => ["id" => $id],];

      return $data;

    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }


  public function update( $params = array() )
  {
    try
    {
      extract($params) ;

      $status  = false;
      $message = "";

      if (empty($idmarca))
      {
        $marca = Marca::find($idmarca);
        $marca->idmarca = $idmarca;
        $marca->nombre = $nombre;
        $marca->publish = $publish;

        $status = $marca->save();

        $message = "Operancion Correcta";

      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];

      return $data;

    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }


  public function find( $idmarca )
  {
    try
    {

      $data = Marca::find($idmarca);

      return $data;

    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }


  public function updateEstado( $params = array() )
  {
    try
    {
      extract($params) ;

      $status  = false;
      $message = "";

      if (empty($idmarca))
      {
        $marca = Marca::find($idmarca);
        $marca->estado = $estado;

        $status = $marca->save();

        $message = "Operancion Correcta";

      }
      else
      {
        $message = "¡El identificador es incorrecto!";
      }

      $data = ["message" => $message, "status" => $status, "data" =>[],];

      return $data;

    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }


  public function delete( $params = array() )
  {
    extract($params) ;
    try
    {
      $status  = false;
      $message = "";

      $historial = !empty($historial) ? $historial: "si";
      $marca = Marca::find( idmarca ) ;

      if (empty($marca))
      {
        $marca = new Marca();
        #conservar en base de datos
        if ( $historial == "si" )
        {
          $categoria->estado = 1;
          $categoria->save();
          $status = true;
          $message = "Registro Eliminado";

        }
        $status = $marca->save();

        $id = $marca->idmarca;

        $message = "Operancion Correcta";

      }
      else
      {
        $message = "¡El registro ya existe!";
      }

      $data = ["message" => $message, "status" => $status, "data" => ["id" => $id],];

      return $data;

    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }


}
