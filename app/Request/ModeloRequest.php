<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class ModeloRequest extends FormRequest
{

  protected $table = "modelo";

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
     'marca_id'  => [],
     'cod_mod'  => [],
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
     'cod_mod'  => 'cod_mod',
     'descripcion'  => 'descripcion',
     'glosa'  => 'glosa',
    ];
  }

}
