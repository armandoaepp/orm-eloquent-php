<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
  protected $table = "convenio";

  protected $fillable = [
     'tipo_convenio_id',
     'con_nombre',
     'con_caracteristica',
     'con_precio',
     'con_publicar',
     'con_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = false;

}
