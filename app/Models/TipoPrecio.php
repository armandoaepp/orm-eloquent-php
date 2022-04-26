<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPrecio extends Model
{
  protected $table = "tipo_precio";

  protected $fillable = [
     'tipo_moneda_id',
     'descripcion',
     'is_base',
     'estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
