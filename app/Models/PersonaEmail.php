<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonaEmail extends Model
{
  protected $table = "persona_email";

  protected $fillable = [
     'persona_id',
     'email',
     'is_principal',
     'estado',
  ];

  protected $primaryKey = 'id';

  protected $guarded = ['id'];

  public $timestamps = true;

  protected $hidden = ['created_at','updated_at','user_id_reg','user_id_upd'];

}
