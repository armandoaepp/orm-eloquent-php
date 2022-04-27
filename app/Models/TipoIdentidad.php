<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoIdentidad extends Model
{
  protected $table = "tipo_identidad";

  protected $fillable = [
     'cod_ti',
     'abrv_ti',
     'descripcion',
     'estado',
  ];

  protected $primaryKey = 'id';

  protected $guarded = ['id'];

  public $timestamps = false;

}
