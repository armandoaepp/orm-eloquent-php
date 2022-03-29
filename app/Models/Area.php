<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
  protected $table = "area";

  protected $fillable = [
     'area_id_sup',
     'descripcion',
     'grupo_id',
     'nivel',
     'estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
