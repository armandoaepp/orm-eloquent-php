<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class PersonaJuridicaRequest extends FormRequest
{

  protected $table = "persona_juridica";

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
     'persona_id'  => [],
     'ruc'  => [],
     'razon_social'  => [],
     'nombre_comercial'  => [],
     'observacion'  => [],
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
     'persona_id'  => 'persona_id',
     'ruc'  => 'ruc',
     'razon_social'  => 'razon_social',
     'nombre_comercial'  => 'nombre_comercial',
     'observacion'  => 'observacion',
    ];
  }

}
