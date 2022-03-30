<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaRequest extends FormRequest
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
  protected $table = "categoria";

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
     'familia_id'  => [],
     'cod_cat'  => [],
     'descripcion'  => [],
     'url'  => [],
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
     'familia_id'  => 'familia_id',
     'cod_cat'  => 'cod_cat',
     'descripcion'  => 'descripcion',
     'url'  => 'url',
     'glosa'  => 'glosa',
    ];
  }

}
