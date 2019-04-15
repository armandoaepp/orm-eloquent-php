<?php
  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  class Propietario extends Model {

    protected $table = "propietario";

    public $timestamps = false;

    protected $guarded = ['id'];

  }
  