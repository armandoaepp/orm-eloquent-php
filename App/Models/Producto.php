<?php
  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  class Producto extends Model {

    protected $table = "producto";

    protected $primaryKey = "id";

    protected $guarded = ["id"];

    // public $timestamps = false;

    // protected $hidden = ["created_at", "updated_at"];


  }
  