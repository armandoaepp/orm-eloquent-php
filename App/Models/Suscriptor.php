<?php
  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  class Suscriptor extends Model {

    protected $table = "suscriptor";

    protected $primaryKey = ["id"];

    protected $guarded = ["id"];

    // public $timestamps = false;

    // protected $hidden = ["created_at", "updated_at"];


  }
  