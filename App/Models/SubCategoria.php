<?php
  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  class SubCategoria extends Model {

    protected $table = "sub_categoria";

    protected $primaryKey = ["id"];

    protected $guarded = ["id"];

    // public $timestamps = false;

    // protected $hidden = ["created_at", "updated_at"];


  }
  