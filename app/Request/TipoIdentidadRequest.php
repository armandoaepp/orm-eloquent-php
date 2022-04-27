<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class TipoIdentidadRequest extends FormRequest
{

  protected $table = "tipo_identidad";

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
     'cod_ti'  => [],
     'abrv_ti'  => [],
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
     'cod_ti'  => 'cod_ti',
     'abrv_ti'  => 'abrv_ti',
     'descripcion'  => 'descripcion',
    ];
  }

}
