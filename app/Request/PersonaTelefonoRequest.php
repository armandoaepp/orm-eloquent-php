<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class PersonaTelefonoRequest extends FormRequest
{

  protected $table = "persona_telefono";

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
     'tipo_telefono_id'  => [],
     'telefono'  => [],
     'observación'  => [],
     'is_principal'  => [],
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
     'tipo_telefono_id'  => 'tipo_telefono_id',
     'telefono'  => 'telefono',
     'observación'  => 'observación',
     'is_principal'  => 'is_principal',
    ];
  }

}
