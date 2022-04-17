<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
  protected $table = "modelo";

  protected $fillable = [
     'marca_id',
     'codigo',
     'descripcion',
     'glosa',
     'publicar',
     'estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
