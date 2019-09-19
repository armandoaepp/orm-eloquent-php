<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParParametro extends Model
{
  protected $table = "par_parametro";

  protected $fillable = [
     'per_id_padre',
     'parametro_id',
     'pp_codigo',
     'pp_jerarquia',
     'pp_nombre',
     'pp_descripcion',
     'pp_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["per_id_padre","created_at", "updated_at"];

}
