<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
  protected $table = "categoria";

  protected $fillable = [
     'categoria_id',
     'cod_subcat',
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
