<?php
  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  class ProductoDetalle extends Model {

    protected $table = "producto_detalle";

    protected $primaryKey = ["id"];

    protected $guarded = ["id"];

    // public $timestamps = false;

    // protected $hidden = ["created_at", "updated_at"];


  }
  