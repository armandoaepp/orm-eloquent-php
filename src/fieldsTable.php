<?php

function fieldsNotSaveInController($item, $prefix = "")
{

  if(!empty($prefix))
  {
    $item = revemoPrefix($item, $prefix)  ;
  }

  //echo $item ." - $prefix - fieldsNotSaveInController <br>" ; 

  $item = strtolower( trim($item) ) ;

  $items = array('id', 'imagen', 'created_at','updated_at', 'user_id_reg', 'user_id_upd') ;

  if ( in_array($item, $items) )
  {
    return true ;
  }
  return false ;

}

function fieldsNotUpdateInController($item, $prefix = "")
{
  if(!empty($prefix))
  {
    $item = revemoPrefix($item, $prefix)  ;
  }

  $item = strtolower( trim($item) ) ;

  $items = array('imagen', 'estado','status','created_at','updated_at', 'user_id_reg', 'user_id_upd') ;

  if ( in_array($item, $items) )
  {
    return true ;
  }
  return false ;

}

function fieldsNotUpdateClassInController($item, $prefix = "")
{
  if(!empty($prefix))
  {
    $item = revemoPrefix($item, $prefix)  ;
  }

  $item = strtolower( trim($item) ) ;

  $items = array('estado','status','created_at','updated_at','user_id_reg', 'user_id_upd') ;

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
function verificarItemNotListTable($item, $prefix = ""){

  $item = strtolower( trim($item) ) ;

  if(!empty($prefix))
  {
    $item = revemoPrefix($item, $prefix)  ;
  }

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

function fieldsNotFillableModel($item, $prefix = "")
{

  if(!empty($prefix))
  {
    $item = revemoPrefix($item, $prefix)  ;
  } 

  $item = strtolower( trim($item) ) ;

  $items = array('id', 'sede_id', 'created_at','updated_at', 'user_id_reg', 'user_id_upd') ;

  if ( in_array($item, $items) )
  {
    return true ;
  }
  return false ;

}