<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerWeb extends Model
{
  protected $table = "per_web";

  protected $fillable = [
     'persona_id',
     'tipo_web_id',
     'pw_url',
     'pw_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
