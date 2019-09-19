<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerDocumento extends Model
{
  protected $table = "per_documento";

  protected $fillable = [
     'persona_id',
     'tipo_per_documento_id',
     'pd_numero',
     'pd_fecha_emision',
     'pd_echa_caducidad',
     'pd_descripcion',
     'pd_imagen',
     'pd_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
