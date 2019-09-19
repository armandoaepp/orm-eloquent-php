<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerJuridica extends Model
{
  protected $table = "per_juridica";

  protected $fillable = [
     'persona_id',
     'rubro_id',
     'pj_ruc',
     'pj_razon_social',
     'pj_nombre_comercial',
     'pj_glosa',
     'pj_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
