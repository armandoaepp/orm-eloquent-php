<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Familia extends Model
{
  protected $table = "familia";

  protected $fillable = [
     'cod_fam',
     'descripcion',
     'url',
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
