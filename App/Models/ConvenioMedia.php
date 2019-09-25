<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConvenioMedia extends Model
{
  protected $table = "convenio_media";

  protected $fillable = [
     'convenio_id',
     'cm_path_file',
     'cm_jerarquia',
     'cm_descripcion',
     'con_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = false;

}
