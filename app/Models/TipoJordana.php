<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoJordana extends Model
{
  protected $table = "tipo_jordana";

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
