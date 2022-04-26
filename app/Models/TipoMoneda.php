<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMoneda extends Model
{
  protected $table = "tipo_moneda";

  protected $fillable = [
     'simbolo',
     'abreviatura',
     'descripcion',
     'estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
