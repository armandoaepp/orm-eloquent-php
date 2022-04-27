<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoTelefono extends Model
{
  protected $table = "tipo_telefono";

  protected $fillable = [
     'descripcion',
     'estado',
  ];

  protected $primaryKey = 'id';

  protected $guarded = ['id'];

  public $timestamps = false;

}
