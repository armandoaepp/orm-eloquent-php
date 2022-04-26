<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class TipoPrecioRequest extends FormRequest
{

  protected $table = "tipo_precio";

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
     'tipo_moneda_id'  => [],
     'descripcion'  => [],
     'is_base'  => [],
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
     'tipo_moneda_id'  => 'tipo_moneda_id',
     'descripcion'  => 'descripcion',
     'is_base'  => 'is_base',
    ];
  }

}
