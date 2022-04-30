<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class PersonaDireccionRequest extends FormRequest
{

  protected $table = "persona_direccion";

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
     'persona_id'  => [],
     'tipo_via_id'  => [],
     'ubigeo_id'  => [],
     'direccion'  => [],
     'referencia'  => [],
     'is_principal'  => [],
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
     'persona_id'  => 'persona_id',
     'tipo_via_id'  => 'tipo_via_id',
     'ubigeo_id'  => 'ubigeo_id',
     'direccion'  => 'direccion',
     'referencia'  => 'referencia',
     'is_principal'  => 'is_principal',
    ];
  }

}
