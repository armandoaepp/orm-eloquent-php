<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class MarcaRequest extends FormRequest
{

  protected $table = "marca";

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
     'cod_mar'  => [],
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
     'cod_mar'  => 'cod_mar',
     'descripcion'  => 'descripcion',
     'glosa'  => 'glosa',
    ];
  }

}
