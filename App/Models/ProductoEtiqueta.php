<?php
  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  class ProductoEtiqueta extends Model {

    protected $table = "producto_etiqueta";

    protected $primaryKey = "id";

    protected $guarded = ["id"];

    // public $timestamps = false;

    // protected $hidden = ["created_at", "updated_at"];


  }
  