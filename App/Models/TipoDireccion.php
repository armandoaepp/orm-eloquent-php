<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDireccion extends Model
{
  protected $table = "tipo_direccion";

  protected $fillable = [
     'td_descripcion',
     'td_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = false;

}
