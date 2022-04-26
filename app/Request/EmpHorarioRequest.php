<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class EmpHorarioRequest extends FormRequest
{

  protected $table = "emp_horario";

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
     'area_id'  => [],
     'tipo_jordana_id'  => [],
     'descripcion'  => [],
     'ingreso'  => [],
     'salida'  => [],
     'ingreso2'  => [],
     'salida2'  => [],
     'ingreso3'  => [],
     'salida3'  => [],
     'duracion'  => [],
     'is_continuo'  => [],
     'dia_siguiente'  => [],
     'ing_tol_antes'  => [],
     'ing_tol_despues'  => [],
     'sal_tol_antes'  => [],
     'sal_tol_despues'  => [],
     'is_tol_ajustar'  => [],
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
     'area_id'  => 'area_id',
     'tipo_jordana_id'  => 'tipo_jordana_id',
     'descripcion'  => 'descripcion',
     'ingreso'  => 'ingreso',
     'salida'  => 'salida',
     'ingreso2'  => 'ingreso2',
     'salida2'  => 'salida2',
     'ingreso3'  => 'ingreso3',
     'salida3'  => 'salida3',
     'duracion'  => 'duracion',
     'is_continuo'  => 'is_continuo',
     'dia_siguiente'  => 'dia_siguiente',
     'ing_tol_antes'  => 'ing_tol_antes',
     'ing_tol_despues'  => 'ing_tol_despues',
     'sal_tol_antes'  => 'sal_tol_antes',
     'sal_tol_despues'  => 'sal_tol_despues',
     'is_tol_ajustar'  => 'is_tol_ajustar',
    ];
  }

}
