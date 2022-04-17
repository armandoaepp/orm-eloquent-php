<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
{

  protected $table = "producto";

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
     'cod_min'  => [],
     'descripcion'  => [],
     'cod_lg'  => [],
     'cod_bar'  => [],
     'url'  => [],
     'sub_categoria_id'  => [],
     'categoria_id'  => [],
     'familia_id'  => [],
     'proveedor_id'  => [],
     'modelo_id'  => [],
     'marca_id'  => [],
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
     'sede_id'  => 'sede_id',
     'cod_min'  => 'cod_min',
     'descripcion'  => 'descripcion',
     'cod_lg'  => 'cod_lg',
     'cod_bar'  => 'cod_bar',
     'url'  => 'url',
     'sub_categoria_id'  => 'sub_categoria_id',
     'categoria_id'  => 'categoria_id',
     'familia_id'  => 'familia_id',
     'proveedor_id'  => 'proveedor_id',
     'modelo_id'  => 'modelo_id',
     'marca_id'  => 'marca_id',
     'glosa'  => 'glosa',
    ];
  }

}
