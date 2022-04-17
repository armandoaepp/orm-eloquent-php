<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model
{
  protected $table = "etiqueta";

  protected $fillable = [
     'desc_eti',
     'estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = false;

}
