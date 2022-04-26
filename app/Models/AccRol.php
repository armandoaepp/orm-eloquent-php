<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccRol extends Model
{
  protected $table = "acc_rol";

  protected $fillable = [
     'sede_id',
     'descripcion',
     'estado',
     'user_id_ins',
     'user_id_upd',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}