<?php
  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  class Users extends Model {

    protected $table = "users";

    protected $primaryKey = ["id"];

    protected $guarded = ["id"];

    // public $timestamps = false;

    // protected $hidden = ["created_at", "updated_at"];


  }
  