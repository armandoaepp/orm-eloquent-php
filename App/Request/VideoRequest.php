<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest
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
  protected $table = "video";

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
     'titulo'  => [],
     'url'  => [],
     'descripcion'  => [],
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
     'titulo'  => 'titulo',
     'url'  => 'url',
     'descripcion'  => 'descripcion',
    ];
  }

}
