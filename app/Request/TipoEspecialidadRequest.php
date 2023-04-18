<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class TipoEspecialidadRequest extends FormRequest
{

  protected $table = "tipo_especialidad";

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
     'descripcion'  => [],
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
     'descripcion'  => 'descripcion',
    ];
  }

}
