<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class PersonaRequest extends FormRequest
{

  protected $table = "persona";

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
     'per_nombre'  => [],
     'per_apellidos'  => [],
     'fecha_nac'  => [],
     'per_tipo'  => [],
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
     'per_nombre'  => 'nombre',
     'per_apellidos'  => 'apellidos',
     'fecha_nac'  => 'fecha_nac',
     'per_tipo'  => 'tipo',
    ];
  }

}
