<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
  protected $table = "persona";

  protected $fillable = [
     'per_id_padre',
     'per_nombre',
     'per_apellidos',
     'per_fecha_nac',
     'per_tipo',
     'per_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["per_id_padre","created_at", "updated_at"];

}
