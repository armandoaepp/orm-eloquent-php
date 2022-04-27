<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerTipoVia extends Model
{
  protected $table = "per_tipo_via";

  protected $fillable = [
     'cod_tv',
     'abrv_via',
     'descripcion',
     'estado',
  ];

  protected $primaryKey = 'id';

  protected $guarded = ['id'];

  public $timestamps = false;

}
