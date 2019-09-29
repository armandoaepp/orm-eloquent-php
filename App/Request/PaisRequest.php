<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class PaisRequest extends FormRequest
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
  protected $table = "pais";

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
     'code'  => [],
     'nombre'  => [],
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
     'code'  => 'code',
     'nombre'  => 'nombre',
    ];
  }

}
