<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
  protected $table = "rol";

  protected $fillable = [
     'per_id_padre',
     'nombre',
     'descripcion',
     'estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = false;

  protected $hidden = ["per_id_padre"];

}
