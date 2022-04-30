<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonaTipoIdentidad extends Model
{
  protected $table = "persona_tipo_identidad";

  protected $fillable = [
     'cod_ti',
     'abreviatura',
     'descripcion',
     'estado',
  ];

  protected $primaryKey = 'id';

  protected $guarded = ['id'];

  public $timestamps = false;

}
