<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
  protected $table = "servicio";

  protected $fillable = [
     'ser_descripcion',
     'ser_icono',
     'ser_incluye',
     'ser_publicar',
     'ser_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = false;

}
