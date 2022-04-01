<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Corporacion extends Model
{
  protected $table = "corporacion";

  protected $fillable = [
     'ruc',
     'razon_social',
     'nombre_com',
     'ubigeo_id',
     'direccion',
     'estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
