<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class SedeRequest extends FormRequest
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
  protected $table = "sede";

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
     'sede_id'  => [],
     'corporacion_id'  => [],
     'nombre'  => [],
     'ubigeo_id'  => [],
     'direccion'  => [],
     'principal'  => [],
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
     'sede_id'  => 'sede_id',
     'corporacion_id'  => 'corporacion_id',
     'nombre'  => 'nombre',
     'ubigeo_id'  => 'ubigeo_id',
     'direccion'  => 'direccion',
     'principal'  => 'principal',
    ];
  }

}
