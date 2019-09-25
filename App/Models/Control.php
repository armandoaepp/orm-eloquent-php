<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
  protected $table = "control";

  protected $fillable = [
     'control_padre_id',
     'tipo_control_id',
     'jerarquia',
     'nombre',
     'valor',
     'descripcion',
     'glosa',
     'estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = false;

}
