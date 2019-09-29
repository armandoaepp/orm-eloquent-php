<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class PaqueteRequest extends FormRequest
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
  protected $table = "paquete";

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
     'ubigeo_id'  => [],
     'nombre'  => [],
     'descripcion'  => [],
     'recomendacion'  => [],
     'num_dias'  => [],
     'num_noches'  => [],
     'precio'  => [],
     'descuento'  => [],
     'precio_descuento'  => [],
     'fecha_ini_promo'  => [],
     'fecha_fin_promo'  => [],
     'url'  => [],
     'num_visitas'  => [],
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
     'ubigeo_id'  => 'ubigeo_id',
     'nombre'  => 'nombre',
     'descripcion'  => 'descripcion',
     'recomendacion'  => 'recomendacion',
     'num_dias'  => 'num_dias',
     'num_noches'  => 'num_noches',
     'precio'  => 'precio',
     'descuento'  => 'descuento',
     'precio_descuento'  => 'precio_descuento',
     'fecha_ini_promo'  => 'fecha_ini_promo',
     'fecha_fin_promo'  => 'fecha_fin_promo',
     'url'  => 'url',
     'num_visitas'  => 'num_visitas',
    ];
  }

}
