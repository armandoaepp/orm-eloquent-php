<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class TipoJordanaRequest extends FormRequest
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
  protected $table = "tipo_jordana";

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
     'cod_tj'  => [],
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
     'cod_tj'  => 'cod_tj',
     'descripcion'  => 'descripcion',
    ];
  }

}
