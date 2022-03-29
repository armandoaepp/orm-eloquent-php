<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class FamiliaRequest extends FormRequest
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
  protected $table = "familia";

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
     'cod_fam'  => [],
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
     'cod_fam'  => 'cod_fam',
     'descripcion'  => 'descripcion',
     'url'  => 'url',
     'glosa'  => 'glosa',
    ];
  }

}
