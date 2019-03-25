<?php
class Encript {

  static public function md5($value)
  {
    $str_encript = md5($value) ;

    return $str_encript;

  }

}