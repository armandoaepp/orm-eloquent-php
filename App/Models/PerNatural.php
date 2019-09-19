<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerNatural extends Model
{
  protected $table = "per_natural";

  protected $fillable = [
     'persona_id',
     'pn_dni',
     'pn_ruc',
     'pn_apellidos',
     'pn_nombres',
     'sexo_id',
     'estado_civil_id',
     'pn_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
