<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaqueteAdicional extends Model
{
  protected $table = "paquete_adicional";

  protected $fillable = [
     'paquete_id',
     'adicional_id',
     'pa_precio',
     'pa_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = false;

}
