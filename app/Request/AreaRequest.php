<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class AreaRequest extends FormRequest
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
  protected $table = "area";

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
     'area_id_sup'  => [],
     'descripcion'  => [],
     'grupo_id'  => [],
     'nivel'  => [],
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
     'area_id_sup'  => 'area_id_sup',
     'descripcion'  => 'descripcion',
     'grupo_id'  => 'grupo_id',
     'nivel'  => 'nivel',
    ];
  }

}
