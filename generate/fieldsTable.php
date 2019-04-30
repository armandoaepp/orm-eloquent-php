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