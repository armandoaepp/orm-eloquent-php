<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerDocIdentidad extends Model
{
  protected $table = "per_doc_identidad";

  protected $fillable = [
     'persona_id',
     'tipo_per_doc_identidad_id',
     'pdi_jerarquia',
     'pdi_numero',
     'pdi_fecha_emision',
     'pdi_fecha_caducidad',
     'pdi_imagen',
     'pdi_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
