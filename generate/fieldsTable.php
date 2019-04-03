<?php

function fieldsNotSaveInController($item)
{
  $item = strtolower( trim($item) ) ;

  $items = array('created_up','updated_up') ;

  if ( in_array($item, $items) )
  {
    return true ;
  }
  return false ;

}

function fieldsNotUpdateInController($item)
{
  $item = strtolower( trim($item) ) ;

  $items = array('estado','status','created_up','updated_up') ;

  if ( in_array($item, $items) )
  {
    return true ;
  }
  return false ;

}