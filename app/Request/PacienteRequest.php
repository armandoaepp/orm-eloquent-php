<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class PacienteRequest extends FormRequest
{

  protected $table = "paciente";

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
     'codigo'  => [],
     'num_doc'  => [],
     'apellidos'  => [],
     'nombres'  => [],
     'telefono'  => [],
     'direccion'  => [],
     'sexo'  => [],
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
     'codigo'  => 'codigo',
     'num_doc'  => 'num_doc',
     'apellidos'  => 'apellidos',
     'nombres'  => 'nombres',
     'telefono'  => 'telefono',
     'direccion'  => 'direccion',
     'sexo'  => 'sexo',
    ];
  }

}
