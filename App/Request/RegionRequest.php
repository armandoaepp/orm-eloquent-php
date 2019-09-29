<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class RegionRequest extends FormRequest
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
  protected $table = "region";

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
     'reg_nombre'  => [],
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
     'reg_nombre'  => nombre,
    ];
  }

}
