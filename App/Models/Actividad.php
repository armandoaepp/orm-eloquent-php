<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
  protected $table = "actividad";

  protected $fillable = [
     'act_nombre',
     'act_horas',
     'act_descripcion',
     'act_publicar',
     'act_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = false;

}
