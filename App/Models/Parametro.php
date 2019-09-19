<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
  protected $table = "parametro";

  protected $fillable = [
     'per_id_padre',
     'par_jerarquia',
     'par_nombre',
     'par_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["per_id_padre","created_at", "updated_at"];

}
