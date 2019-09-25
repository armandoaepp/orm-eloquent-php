<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
  protected $table = "bitacora";

  protected $fillable = [
     'user_id',
     'action',
     'table_id',
     'table',
     'computer_ip',
     'new_value',
     'old_value',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
