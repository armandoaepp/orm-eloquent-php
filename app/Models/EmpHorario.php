<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpHorario extends Model
{
  protected $table = "emp_horario";

  protected $fillable = [
     'area_id',
     'tipo_jordana_id',
     'descripcion',
     'ingreso',
     'salida',
     'ingreso2',
     'salida2',
     'ingreso3',
     'salida3',
     'duracion',
     'is_continuo',
     'dia_siguiente',
     'ing_tol_antes',
     'ing_tol_despues',
     'sal_tol_antes',
     'sal_tol_despues',
     'is_tol_ajustar',
     'estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
