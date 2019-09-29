<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class RolRequest extends FormRequest
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
  protected $table = "rol";

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
     'nombre'  => [],
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
     'nombre'  => 'nombre',
     'descripcion'  => 'descripcion',
    ];
  }

}
