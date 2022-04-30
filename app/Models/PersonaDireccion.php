<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonaDireccion extends Model
{
  protected $table = "persona_direccion";

  protected $fillable = [
     'persona_id',
     'tipo_via_id',
     'ubigeo_id',
     'direccion',
     'referencia',
     'is_principal',
     'jerarquia',
     'estado',
  ];

  protected $primaryKey = 'id';

  protected $guarded = ['id'];

  public $timestamps = false;

}
