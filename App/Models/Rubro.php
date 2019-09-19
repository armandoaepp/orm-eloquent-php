<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rubro extends Model
{
  protected $table = "rubro";

  protected $fillable = [
     'rub_descripcion',
     'rub_codigo',
     'rub_glosa',
     'rub_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
