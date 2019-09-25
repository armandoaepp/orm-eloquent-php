<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Itinerario extends Model
{
  protected $table = "itinerario";

  protected $fillable = [
     'paquete_id',
     'iti_dia',
     'iti_titulo',
     'iti_descripcion',
     'iti_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
