<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoCivil extends Model
{
  protected $table = "estado_civil";

  protected $fillable = [
     'cod_ec',
     'descripcion',
     'estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = false;

}
