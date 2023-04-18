<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoEspecialidad extends Model
{
  protected $table = "tipo_especialidad";

  protected $fillable = [
     'descripcion',
     'publicar',
     'estado',
  ];

  protected $primaryKey = 'id';

  protected $guarded = ['id'];

  public $timestamps = true;

  protected $hidden = ['created_at','updated_at','user_id_reg','user_id_upd'];

}
