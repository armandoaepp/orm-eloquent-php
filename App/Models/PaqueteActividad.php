<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaqueteActividad extends Model
{
  protected $table = "paquete_actividad";

  protected $fillable = [
     'paquete_id',
     'actividad_id',
     'pa_horas',
     'pa_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = false;

}
