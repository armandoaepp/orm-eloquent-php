<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class ConceptoPlanillaRequest extends FormRequest
{

  protected $table = "concepto_planilla";

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
     'empleado_id'  => [],
     'periodo_id'  => [],
     'tipo_concepto_id'  => [],
     'fecha'  => [],
     'monto'  => [],
     'descripcion'  => [],
     'estado_pagado'  => [],
    ];
  }
  /**
   * Get the validation attributes that apply to the request.
   *
   * @return array
   */
  public function attributes()
  {
    return [
     'empleado_id'  => 'empleado_id',
     'periodo_id'  => 'periodo_id',
     'tipo_concepto_id'  => 'tipo_concepto_id',
     'fecha'  => 'fecha',
     'monto'  => 'monto',
     'descripcion'  => 'descripcion',
     'estado_pagado'  => 'estado_pagado',
    ];
  }

}
