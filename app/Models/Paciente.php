<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
  protected $table = "paciente";

  protected $fillable = [
     'persona_id',
     'codigo',
     'num_doc',
     'apellidos',
     'nombres',
     'telefono',
     'direccion',
     'sexo',
     'estado',
  ];

  protected $primaryKey = 'id';

  protected $guarded = ['id'];

  public $timestamps = true;

  protected $hidden = ['created_at','updated_at','sede_id','user_id_reg','user_id_upd'];

}
