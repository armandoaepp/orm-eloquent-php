<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class ModeloRequest extends FormRequest
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
  protected $table = "modelo";

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
     'marca_id'  => [],
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
     'marca_id'  => 'marca_id',
     'codigo'  => 'codigo',
     'descripcion'  => 'descripcion',
     'glosa'  => 'glosa',
    ];
  }

}
