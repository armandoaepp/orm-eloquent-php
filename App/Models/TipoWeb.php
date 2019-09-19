<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoWeb extends Model
{
  protected $table = "tipo_web";

  protected $fillable = [
     'tw_descripcion',
     'tw_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = false;

}
