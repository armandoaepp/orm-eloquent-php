<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ubigeo extends Model
{
  protected $table = "ubigeo";

  protected $fillable = [
     'pais_id',
     'ubigeo_id_padre',
     'ubi_codigo',
     'ubi_ubigeo',
     'ubi_descripcion',
     'tipo_ubigeo_id',
     'ubi_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
