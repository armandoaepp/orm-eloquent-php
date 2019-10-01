<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class ServicioRequest extends FormRequest
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
  protected $table = "servicio";

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
     'ser_descripcion'  => [],
     'ser_icono'  => [],
     'ser_incluye'  => [],
     'ser_no_incluye'  => [],
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
     'ser_descripcion'  => 'descripcion',
     'ser_icono'  => 'icono',
     'ser_incluye'  => 'incluye',
     'ser_no_incluye'  => 'no_incluye',
    ];
  }

}
