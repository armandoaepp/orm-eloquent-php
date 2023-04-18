<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoCita extends Model
{
  protected $table = "estado_cita";

  protected $fillable = [
     'descripcion',
     'estado',
  ];

  protected $primaryKey = 'id';

  protected $guarded = ['id'];

  public $timestamps = true;

  protected $hidden = ['created_at','updated_at'];

}
