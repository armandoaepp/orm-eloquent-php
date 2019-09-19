<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
  protected $table = "docente";

  protected $fillable = [
     'per_id_padre',
     'persona_id',
     'doc_codigo',
     'doc_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = false;

  protected $hidden = ["per_id_padre"];

}
