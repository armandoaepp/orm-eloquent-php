<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonaNatural extends Model
{
  protected $table = "persona_natural";

  protected $fillable = [
     'persona_id',
     'tipo_identidad_id',
     'num_doc',
     'ape_paterno',
     'ape_materno',
     'nombres',
     'full_name',
     'sexo',
     'estado_civil_id',
     'estado',
  ];

  protected $primaryKey = 'id';

  protected $guarded = ['id'];

  public $timestamps = true;

  protected $hidden = ['created_at','updated_at','user_id_reg','user_id_upd'];

}
