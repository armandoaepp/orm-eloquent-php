<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonaTelefono extends Model
{
  protected $table = "persona_telefono";

  protected $fillable = [
     'persona_id',
     'tipo_telefono_id',
     'telefono',
     'observación',
     'is_principal',
     'jerarquia',
     'estado',
  ];

  protected $primaryKey = 'id';

  protected $guarded = ['id'];

  public $timestamps = false;

}
