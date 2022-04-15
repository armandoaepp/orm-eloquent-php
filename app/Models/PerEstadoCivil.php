<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerEstadoCivil extends Model
{
  protected $table = "per_estado_civil";

  protected $fillable = [
     'cod_ec',
     'descripcion',
     'estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = false;

}
