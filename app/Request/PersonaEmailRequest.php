<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class PersonaEmailRequest extends FormRequest
{

  protected $table = "persona_email";

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
     'email'  => [],
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
     'email'  => 'email',
     'is_principal'  => 'is_principal',
    ];
  }

}
