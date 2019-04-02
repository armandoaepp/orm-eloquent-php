<?php

namespace App\Controllers;


use App\Models\Categoria;

class CategoriasController
{
  public function __construct() { }

  public function getAll()
  {
    try
    {

      $data = Categoria::get();

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

      $categoria = Categoria::where(["nombre" => $nombre])->first();

      if (empty($categoria))
      {
        $categoria = new Categoria();

        $categoria->nombre   = $nombre;
        $categoria->url      = $url;
        $categoria->imagen   = $imagen;
        $categoria->publicar = $publicar;

        $status = $categoria->save();

        $id = $categoria->id ;

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

  public function update( $params = array() )
  {

    try
    {
      extract($params) ;

      $status  = false;
      $message = "";

      if (!empty($id))
      {

        $categoria = Categoria::find($id);
        $categoria->nombre   = $nombre;
        $categoria->url      = $url;
        $categoria->imagen   = $imagen;
        $categoria->publicar = $publicar;

        $status = $categoria->save();

        $message = "Operancion Correcta";

      } else {
        $message = "¡El Registro No exite!";
      }

      $data = [
            "message" => $message,
            "status" => $status,
            "data" => [],
          ];

      return $data ;
    }
    catch (Exception $e)
    {
        throw new Exception($e->getMessage());
    }
  }

  public function find($id)
  {
    try
    {

      $data = Categoria::where("id", $id)
                        ->get();

      return $data ;
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }
  }

  public function delete( $params = array() )
  {
    try {
        extract($params) ;

        $id        = $id;
        $state    = $state;
        $historial = !empty($historial) ? $historial: "";

        $status = false;
        $categoria = Categoria::find($id);

        if ($categoria)
        {
          #conservar en base de datos
          if ( $historial == "si" )
          {
            if ($state == 1)
            {
              $state = 0;
            } else {
              $state = 1;
            }

            $categoria->state = $state;
            $categoria->save();

            $status = true;

          } elseif( $historial == "no"  ) {
            $categoria->forceDelete();

            $status = true;
          }
          else
          {
            $status = false;
          }

        }

        $data = [
          "message" => $message,
          "status" => $status,
          "data" => [],
        ];

    }
    catch (Exception $e)
    {
        throw new Exception($e->getMessage());
    }

  }

  public function getByState( $params = array() )
  {
    try
    {
      extract($params) ;

      $data = Categoria::where("state", $state)
              ->get();

      return $data ;
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }
  }

  public function updatePublish($params = array())
  {
    try
    {

      extract($params) ;

      $status = false;
      $message = "" ;

      $categoria = Categoria::find($id);

      if ($categoria)
      {
        $categoria->publish = $publish;
        $status = $categoria->save();

        $message = "Operación Correcta" ;
      }
      else
      {
        $message = "Registro no exite!" ;
      }

      $data = [
        "message" => $message,
        "status" => $status,
        "data" => [],
      ];

      return $data;
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }

  }

  public function getPublished( $publish )
  {
    try
    {

      $data = Categoria::where("publish", $publish)
                      ->get();

      return $data ;
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }
  }


}