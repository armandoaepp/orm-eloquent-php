<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adicional extends Model
{
  protected $table = "adicional";

  protected $fillable = [
     'adi_descripcion',
     'adi_precio',
     'adi_publicar',
     'adi_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = false;

}
