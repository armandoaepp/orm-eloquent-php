<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class EstadoCitaRequest extends FormRequest
{

  protected $table = "estado_cita";

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
     'descripcion'  => 'descripcion',
    ];
  }

}
