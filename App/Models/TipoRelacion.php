<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoRelacion extends Model
{
  protected $table = "tipo_relacion";

  protected $fillable = [
     'tr_descripcion',
     'tr_glosa',
     'tr_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = false;

}
