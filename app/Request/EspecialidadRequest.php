<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class EspecialidadRequest extends FormRequest
{

  protected $table = "especialidad";

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
     'tipo_especialidad_id'  => [],
     'cod_esp'  => [],
     'descripcion'  => [],
     'observacion'  => [],
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
     'tipo_especialidad_id'  => 'tipo_especialidad_id',
     'cod_esp'  => 'cod_esp',
     'descripcion'  => 'descripcion',
     'observacion'  => 'observacion',
    ];
  }

}
