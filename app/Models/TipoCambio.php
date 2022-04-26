<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoCambio extends Model
{
  protected $table = "tipo_cambio";

  protected $fillable = [
     'fecha',
     'valor',
     'estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
