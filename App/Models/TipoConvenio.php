<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoConvenio extends Model
{
  protected $table = "tipo_convenio";

  protected $fillable = [
     'tc_descripcion',
     'tc_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = false;

}
