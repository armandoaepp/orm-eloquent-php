<?php
  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  class ProductoMedia extends Model {

    protected $table = "producto_media";

    protected $primaryKey = "id";

    protected $guarded = ["id"];

    // public $timestamps = false;

    // protected $hidden = ["created_at", "updated_at"];


  }
  