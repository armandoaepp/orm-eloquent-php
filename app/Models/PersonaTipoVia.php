<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonaTipoVia extends Model
{
  protected $table = "persona_tipo_via";

  protected $fillable = [
     'cod_tv',
     'abreviatura',
     'descripcion',
     'estado',
  ];

  protected $primaryKey = 'id';

  protected $guarded = ['id'];

  public $timestamps = false;

}
