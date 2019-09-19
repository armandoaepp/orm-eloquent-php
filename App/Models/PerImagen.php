<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerImagen extends Model
{
  protected $table = "per_imagen";

  protected $fillable = [
     'persona_id',
     'pi_imagen',
     'pi_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = false;

}
