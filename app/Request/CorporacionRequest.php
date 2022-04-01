<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class CorporacionRequest extends FormRequest
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
  protected $table = "corporacion";

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
     'ruc'  => [],
     'razon_social'  => [],
     'nombre_com'  => [],
     'ubigeo_id'  => [],
     'direccion'  => [],
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
     'ruc'  => 'ruc',
     'razon_social'  => 'razon_social',
     'nombre_com'  => 'nombre_com',
     'ubigeo_id'  => 'ubigeo_id',
     'direccion'  => 'direccion',
    ];
  }

}
