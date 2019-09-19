<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerRelacion extends Model
{
  protected $table = "per_relacion";

  protected $fillable = [
     'persona_id',
     'tipo_relacion_id',
     'referencia',
     'pr_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
