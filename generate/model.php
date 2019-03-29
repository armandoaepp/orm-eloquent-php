<?php

$entities = [] ;

if(!empty($_GET["table"]) )
{
 $table_name = $_GET["table"];
 $entities = Capsule::select("describe ".$table_name);
}
else{
  $table_name = "" ;
}