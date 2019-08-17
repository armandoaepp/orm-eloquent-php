<?php
  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  class Etiqueta extends Model {

    protected $table = "etiqueta";

    protected $primaryKey = ["id"];

    protected $guarded = ["id"];

    // public $timestamps = false;

    // protected $hidden = ["created_at", "updated_at"];


  }
  