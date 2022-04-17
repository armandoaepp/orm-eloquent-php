<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
  protected $table = "marca";

  protected $fillable = [
     'codigo',
     'descripcion',
     'glosa',
     'imagen',
     'publicar',
     'estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
