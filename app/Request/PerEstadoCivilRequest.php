<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class PerEstadoCivilRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }
  protected $table = "per_estado_civil";

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
     'cod_ec'  => [],
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
     'cod_ec'  => 'cod_ec',
     'descripcion'  => 'descripcion',
    ];
  }

}
