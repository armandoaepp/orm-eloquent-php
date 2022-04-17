<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
  protected $table = "proveedor";

  protected $fillable = [
     'ruc',
     'razon_social',
     'nombre_comercial',
     'condicion_su',
     'estado_su',
     'domicilio_fiscal',
     'ubigeo_su',
     'glosa',
     'estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
