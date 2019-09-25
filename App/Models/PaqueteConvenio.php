<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaqueteConvenio extends Model
{
  protected $table = "paquete_convenio";

  protected $fillable = [
     'paquete_id',
     'convenio_id',
     'pc_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
