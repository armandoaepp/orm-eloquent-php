<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPerDocIdentidad extends Model
{
  protected $table = "tipo_per_doc_identidad";

  protected $fillable = [
     'tpdi_descripcion',
     'tpdi_glosa',
     'tpdi_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = false;

}
