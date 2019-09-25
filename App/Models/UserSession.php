<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
  protected $table = "user_session";

  protected $fillable = [
     'user_id',
     'date_login',
     'date_logout',
     'token',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
