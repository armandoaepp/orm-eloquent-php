<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class EtiquetaRequest extends FormRequest
{

  protected $table = "etiqueta";

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
     'desc_eti'  => [],
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
     'desc_eti'  => 'desc_eti',
    ];
  }

}
