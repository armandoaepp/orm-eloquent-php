<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonaDocIdentidad extends Model
{
  protected $table = "persona_doc_identidad";

  protected $fillable = [
     'persona_id',
     'tipo_identidad_id',
     'num_doc',
     'is_principal',
     'fecha_emision',
     'fecha_caducidad',
     'imagen',
     'estado',
  ];

  protected $primaryKey = 'id';

  protected $guarded = ['id'];

  public $timestamps = true;

  protected $hidden = ['created_at','updated_at','user_id_reg','user_id_upd'];

}
