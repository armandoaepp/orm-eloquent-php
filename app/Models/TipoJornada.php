<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoJornada extends Model
{
  protected $table = "tipo_jornada";

  protected $fillable = [
     'cod_tj',
     'descripcion',
     'estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
