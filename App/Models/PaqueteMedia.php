<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaqueteMedia extends Model
{
  protected $table = "paquete_media";

  protected $fillable = [
     'paquete_id',
     'tipo_media_id',
     'pm_path_file',
     'pm_jerarquia',
     'pm_descripcion',
     'pm_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = false;

}
