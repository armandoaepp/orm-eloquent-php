<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
  protected $table = "especialidad";

  protected $fillable = [
     'tipo_especialidad_id',
     'cod_esp',
     'descripcion',
     'observacion',
     'publicar',
     'estado',
  ];

  protected $primaryKey = 'id';

  protected $guarded = ['id'];

  public $timestamps = true;

  protected $hidden = ['created_at','updated_at','user_id_reg','user_id_upd'];

}
