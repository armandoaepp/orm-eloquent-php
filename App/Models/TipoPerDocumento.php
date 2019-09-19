<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPerDocumento extends Model
{
  protected $table = "tipo_per_documento";

  protected $fillable = [
     'tpd_descripcion',
     'tpd_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = false;

}
