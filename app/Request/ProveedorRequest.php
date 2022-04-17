<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class ProveedorRequest extends FormRequest
{

  protected $table = "proveedor";

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
     'ruc'  => [],
     'razon_social'  => [],
     'nombre_comercial'  => [],
     'condicion_su'  => [],
     'estado_su'  => [],
     'domicilio_fiscal'  => [],
     'ubigeo_su'  => [],
     'glosa'  => [],
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
     'ruc'  => 'ruc',
     'razon_social'  => 'razon_social',
     'nombre_comercial'  => 'nombre_comercial',
     'condicion_su'  => 'condicion_su',
     'estado_su'  => 'estado_su',
     'domicilio_fiscal'  => 'domicilio_fiscal',
     'ubigeo_su'  => 'ubigeo_su',
     'glosa'  => 'glosa',
    ];
  }

}
