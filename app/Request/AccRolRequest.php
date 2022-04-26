<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class AccRolRequest extends FormRequest
{

  protected $table = "acc_rol";

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
     'sede_id'  => [],
     'descripcion'  => [],
     'user_id_ins'  => [],
     'user_id_upd'  => [],
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
     'descripcion'  => 'descripcion',
     'user_id_ins'  => 'user_id_ins',
     'user_id_upd'  => 'user_id_upd',
    ];
  }

}
