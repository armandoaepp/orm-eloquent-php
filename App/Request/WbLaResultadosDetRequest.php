<?php
namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class WbLaResultadosDetRequest extends FormRequest
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
  protected $table = "wb_la_resultados_det";

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
     'invnum'  => [],
     'exacod'  => [],
     'exades'  => [],
     'numitm'  => [],
     'numprm'  => [],
     'codprm'  => [],
     'desprm'  => [],
     'estprm'  => [],
     'obsres'  => [],
     'und'  => [],
     'tifprm'  => [],
     'valref'  => [],
     'valref2'  => [],
     'ran1'  => [],
     'ran2'  => [],
     'resexa_n'  => [],
     'color'  => [],
     'res'  => [],
     'res2'  => [],
     'rentre'  => [],
     'estado_wb'  => [],
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
     'invnum'  => 'invnum',
     'exacod'  => 'exacod',
     'exades'  => 'exades',
     'numitm'  => 'numitm',
     'numprm'  => 'numprm',
     'codprm'  => 'codprm',
     'desprm'  => 'desprm',
     'estprm'  => 'estprm',
     'obsres'  => 'obsres',
     'und'  => 'und',
     'tifprm'  => 'tifprm',
     'valref'  => 'valref',
     'valref2'  => 'valref2',
     'ran1'  => 'ran1',
     'ran2'  => 'ran2',
     'resexa_n'  => 'resexa_n',
     'color'  => 'color',
     'res'  => 'res',
     'res2'  => 'res2',
     'rentre'  => 'rentre',
     'estado_wb'  => 'estado_wb',
    ];
  }

}
