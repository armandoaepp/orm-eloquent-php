<?php
  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  class CuentaHost extends Model {

    protected $table = "cuenta_host";

    public $timestamps = false;

    protected $guarded = ['id'];

  }
  