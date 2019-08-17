<?php
  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  class Categoria extends Model {

    protected $table = "categoria";

    protected $primaryKey = ["id"];

    protected $guarded = ["id"];

    // public $timestamps = false;

    // protected $hidden = ["created_at", "updated_at"];


  }
  