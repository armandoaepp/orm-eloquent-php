<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
  protected $table = "persona";

  protected $fillable = [
     'per_nombre',
     'per_apellidos',
     'fecha_nac',
     'per_tipo',
     'estado',
  ];

  protected $primaryKey = 'id';

  protected $guarded = ['id'];

  public $timestamps = true;

  protected $hidden = ['created_at','updated_at','sede_id','user_id_reg','user_id_upd'];

}
