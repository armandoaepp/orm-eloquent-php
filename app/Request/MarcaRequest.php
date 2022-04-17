<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class MarcaRequest extends FormRequest
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
  protected $table = "marca";

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
     'codigo'  => [],
     'descripcion'  => [],
     'glosa'  => [],
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
     'codigo'  => 'codigo',
     'descripcion'  => 'descripcion',
     'glosa'  => 'glosa',
    ];
  }

}
