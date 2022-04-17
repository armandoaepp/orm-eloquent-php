<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
  protected $table = "producto";

  protected $fillable = [
     'sede_id',
     'cod_min',
     'descripcion',
     'cod_lg',
     'cod_bar',
     'url',
     'sub_categoria_id',
     'categoria_id',
     'familia_id',
     'proveedor_id',
     'modelo_id',
     'marca_id',
     'glosa',
     'publicar',
     'estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
