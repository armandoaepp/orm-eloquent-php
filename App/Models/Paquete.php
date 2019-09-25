<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paquete extends Model
{
  protected $table = "paquete";

  protected $fillable = [
     'ubigeo_id',
     'nombre',
     'descripcion',
     'recomendacion',
     'num_dias',
     'num_noches',
     'precio',
     'descuento',
     'precio_descuento',
     'fecha_ini_promo',
     'fecha_fin_promo',
     'url',
     'num_visitas',
     'publicar',
     'estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
