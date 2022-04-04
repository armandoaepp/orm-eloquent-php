<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
  protected $table = "sede";

  protected $fillable = [
     'corporacion_id',
     'nombre',
     'ubigeo_id',
     'direccion',
     'principal',
     'estado',
  ];

  protected $primaryKey = "sede_id";

  protected $guarded = ["sede_id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
