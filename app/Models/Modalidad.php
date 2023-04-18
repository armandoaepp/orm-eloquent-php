<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modalidad extends Model
{
  protected $table = "modalidad";

  protected $fillable = [
     'descripcion',
     'estado',
  ];

  protected $primaryKey = 'id';

  protected $guarded = ['id'];

  public $timestamps = true;

  protected $hidden = ['created_at','updated_at'];

}
