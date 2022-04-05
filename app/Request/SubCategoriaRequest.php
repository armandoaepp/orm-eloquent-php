<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoriaRequest extends FormRequest
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
  protected $table = "sub_categoria";

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
     'categoria_id'  => [],
     'cod_subcat'  => [],
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
     'categoria_id'  => 'categoria_id',
     'cod_subcat'  => 'cod_subcat',
     'descripcion'  => 'descripcion',
     'url'  => 'url',
     'glosa'  => 'glosa',
    ];
  }

}
