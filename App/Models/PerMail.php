<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerMail extends Model
{
  protected $table = "per_mail";

  protected $fillable = [
     'persona_id',
     'pm_jerarquia',
     'pm_mail',
     'pm_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = false;

}
