<?php

function generatePrefixTable($table_name)
{
  $table_name = trim($table_name);
  $porciones = explode("_", $table_name);
  //  var_dump($porciones);

  $prefix = "" ;
  if (count($porciones) > 1)
  {
    for ($i=0; $i < count($porciones) ; $i++)
    {
      $prefix .= substr( $porciones[$i] , 0, 1);
      // echo $prefix."<br>";
    }
  }
  else
  {
    $prefix .= substr( $table_name , 0, 3);
  }


  return $prefix ;

}

function revemoPrefix($string, $prefix)
{
  $string = trim($string);

  if ( empty($prefix) ) return $string ;

  $pos = strpos($string, $prefix);
  $str = "";

  if ($pos === false)
  {
    $str = $string ;
  }
  else
  {
    $str = substr( $string , strlen($prefix));
    // echo str_replace($prefix, "truth", $my_str);
  }
  return $str ;
}