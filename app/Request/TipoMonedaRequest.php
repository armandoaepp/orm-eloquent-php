<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class TipoMonedaRequest extends FormRequest
{

  protected $table = "tipo_moneda";

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
     'simbolo'  => [],
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
     'simbolo'  => 'simbolo',
     'abreviatura'  => 'abreviatura',
     'descripcion'  => 'descripcion',
    ];
  }

}
