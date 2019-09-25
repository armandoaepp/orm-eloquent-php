<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
  protected $table = "region";

  protected $fillable = [
     'reg_nombre',
     'reg_estado',
  ];

  protected $primaryKey = "id";

  protected $guarded = ["id"];

  public $timestamps = true;

  protected $hidden = ["created_at", "updated_at"];

}
