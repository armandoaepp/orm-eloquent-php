<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControlRol extends Model
{
  protected $table = "control_rol";

  protected $fillable = [
     'rol_id',
     'control_id',
     'estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
