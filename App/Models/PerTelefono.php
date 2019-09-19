<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerTelefono extends Model
{
  protected $table = "per_telefono";

  protected $fillable = [
     'tipo_telefono_id',
     'pt_jerarquia',
     'pt_telefono',
     'pt_estado',
  ];

  protected $primaryKey = "persona_id";

  protected $guarded = ["persona_id"];

  public $timestamps = false;

}
