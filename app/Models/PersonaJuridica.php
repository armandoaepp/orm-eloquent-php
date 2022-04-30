<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonaJuridica extends Model
{
  protected $table = "persona_juridica";

  protected $fillable = [
     'persona_id',
     'ruc',
     'razon_social',
     'nombre_comercial',
     'observacion',
     'estado',
  ];

  protected $primaryKey = 'id';

  protected $guarded = ['id'];

  public $timestamps = true;

  protected $hidden = ['created_at','updated_at','user_id_reg','user_id_upd'];

}
