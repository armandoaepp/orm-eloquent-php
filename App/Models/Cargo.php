<?php
  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  class Cargo extends Model {

    protected $table = "cargo";

    public $timestamps = true;

    protected $guarded = ['id'];

  }
