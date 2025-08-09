<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConceptoPlanilla extends Model
{
  protected $table = "concepto_planilla";

  protected $fillable = [
     'empleado_id',
     'periodo_id',
     'tipo_concepto_id',
     'fecha',
     'monto',
     'descripcion',
     'estado_pagado',
     'estado',
  ];

  protected $primaryKey = 'id';

  protected $guarded = ['id'];

  public $timestamps = true;

  protected $hidden = ['created_at','updated_at','user_id_reg','user_id_upd'];

}
