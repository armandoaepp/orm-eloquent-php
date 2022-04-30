<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class PersonaNaturalRequest extends FormRequest
{

  protected $table = "persona_natural";

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
     'tipo_identidad_id'  => [],
     'num_doc'  => [],
     'ape_paterno'  => [],
     'ape_materno'  => [],
     'nombres'  => [],
     'full_name'  => [],
     'sexo'  => [],
     'estado_civil_id'  => [],
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
     'tipo_identidad_id'  => 'tipo_identidad_id',
     'num_doc'  => 'num_doc',
     'ape_paterno'  => 'ape_paterno',
     'ape_materno'  => 'ape_materno',
     'nombres'  => 'nombres',
     'full_name'  => 'full_name',
     'sexo'  => 'sexo',
     'estado_civil_id'  => 'estado_civil_id',
    ];
  }

}
