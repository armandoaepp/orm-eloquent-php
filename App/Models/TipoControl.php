<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoControl extends Model
{
  protected $table = "tipo_control";

  protected $fillable = [
     'descripcion',
     'glosa',
     'estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = false;

}
