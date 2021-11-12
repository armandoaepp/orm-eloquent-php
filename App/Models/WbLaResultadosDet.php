<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WbLaResultadosDet extends Model
{
  protected $table = "wb_la_resultados_det";

  protected $fillable = [
     'exacod',
     'exades',
     'numitm',
     'numprm',
     'codprm',
     'desprm',
     'estprm',
     'obsres',
     'und',
     'tifprm',
     'valref',
     'valref2',
     'ran1',
     'ran2',
     'resexa_n',
     'color',
     'res',
     'res2',
     'rentre',
     'estado_wb',
  ];

  protected $primaryKey = "invnum";

  protected $guarded = ["invnum"];

  public $timestamps = false;

}
