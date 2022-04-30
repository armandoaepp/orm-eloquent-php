<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class PersonaDocIdentidadRequest extends FormRequest
{

  protected $table = "persona_doc_identidad";

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
     'is_principal'  => [],
     'fecha_emision'  => [],
     'fecha_caducidad'  => [],
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
     'is_principal'  => 'is_principal',
     'fecha_emision'  => 'fecha_emision',
     'fecha_caducidad'  => 'fecha_caducidad',
    ];
  }

}
