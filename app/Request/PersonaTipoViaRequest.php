<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class PersonaTipoViaRequest extends FormRequest
{

  protected $table = "persona_tipo_via";

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
     'cod_tv'  => [],
     'abreviatura'  => [],
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
     'cod_tv'  => 'cod_tv',
     'abreviatura'  => 'abreviatura',
     'descripcion'  => 'descripcion',
    ];
  }

}
