<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMedia extends Model
{
  protected $table = "tipo_media";

  protected $fillable = [
     'tm_descripcion',
     'tm_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
