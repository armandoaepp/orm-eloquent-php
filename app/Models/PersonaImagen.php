<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonaImagen extends Model
{
  protected $table = "persona_imagen";

  protected $fillable = [
     'persona_id',
     'url',
     'tipo',
     'is_principal',
     'jerarquia',
     'estado',
  ];

  protected $primaryKey = 'id';

  protected $guarded = ['id'];

  public $timestamps = false;

}
