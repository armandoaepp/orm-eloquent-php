<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
  protected $table = "users";

  protected $fillable = [
     'per_id_padre',
     'rol_id',
     'persona_id',
     'email',
     'password',
     'nombre',
     'apellidos',
     'alias',
     'estado',
     'email_verified_at',
     'remember_token',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["per_id_padre","created_at", "updated_at"];

}
