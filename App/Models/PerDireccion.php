<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerDireccion extends Model
{
  protected $table = "per_direccion";

  protected $fillable = [
     'persona_id',
     'tipo_direccion_id',
     'ubigeo_id',
     'pd_jerarquia',
     'pd_direccion',
     'pd_referencia',
     'pd_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
