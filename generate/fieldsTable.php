<?php

function fieldsNotSaveInController($item)
{
  $item = strtolower( trim($item) ) ;

  $items = array('created_at','updated_at','id') ;

  if ( in_array($item, $items) )
  {
    return true ;
  }
  return false ;

}

function fieldsNotUpdateInController($item)
{
  $item = strtolower( trim($item) ) ;

  $items = array('estado','status','created_at','updated_at') ;

  if ( in_array($item, $items) )
  {
    return true ;
  }
  return false ;

}

/* items que no se mostraran en las vista */
function verificarItemForm($item, $prefix = ""){

  $item = strtolower( trim($item) ) ;

  if(!empty($prefix))
  {
    $item = revemoPrefix($item, $prefix)  ;
  }

  $items = array('id','estado', 'created_at', 'updated_at', 'imagen', 'url', 'publicar') ;

  if ( in_array($item, $items) )
  {
    return true ;
  }
  return false ;

}

/* items que no se mostraran en las vista */
function verificarItemNotListTable($item){

  $item = strtolower( trim($item) ) ;

  $items = array('estado', 'created_at', 'updated_at', 'imagen', 'url', 'publicar') ;

  if ( in_array($item, $items) )
  {
    return true ;
  }
  return false ;

}

function strpos_arr($haystack, $needle)
{
  if(!is_array($needle)) $needle = array($needle);
  foreach($needle as $what) {
      if(($pos = strpos($haystack, $what))!==false) return $pos;
  }
  return false;
}