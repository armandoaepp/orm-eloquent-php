<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
  protected $table = "pais";

  protected $fillable = [
     'code',
     'nombre',
     'estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = false;

}
