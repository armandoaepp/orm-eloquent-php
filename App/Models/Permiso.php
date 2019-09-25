<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
  protected $table = "permiso";

  protected $fillable = [
     'user_id',
     'control_id',
     'estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
