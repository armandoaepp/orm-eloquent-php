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
    $str = substr( $string , strlen($prefix."_"));
    // echo str_replace($prefix, "truth", $my_str);
  }
  return $str ;
}

$prefix1 =  generatePrefixTable( 'producto') ;
echo $prefix1."<br>" ;

$prefix2 = generatePrefixTable("prod_detalle_demo_nuevo") ;
echo $prefix2."<br>" ;

echo revemoPrefix("pro_descripcion", $prefix1) ;
echo "1:::<br>" ;

echo revemoPrefix("pddn_descripcion", $prefix2) ;
echo "2:::<br>" ;



// $pos = strpos($table_name, $prefix);

// // echo substr( $table_name , strlen($prefix)); "<br>";

// if ($pos === false) {
//   echo "La cadena '$findme' no fue encontrada en la cadena '$mystring'";
// } else {
//   echo "La cadena '$findme' fue encontrada en la cadena '$mystring'";
//   echo " y existe en la posición $pos";
// }