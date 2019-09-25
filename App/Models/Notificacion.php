<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
  protected $table = "notificacion";

  protected $fillable = [
     'user_id',
     'asunto',
     'destino',
     'mensaje',
     'referencia',
     'tipo',
     'fecha_envio',
     'estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
