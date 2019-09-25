<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaqueteServicio extends Model
{
  protected $table = "paquete_servicio";

  protected $fillable = [
     'paquete_id',
     'servicio_id',
     'ps_horas',
     'ps_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = false;

}
