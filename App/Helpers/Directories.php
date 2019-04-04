<?php
namespace App\Helpers;

class Directories {

  static public function copyFull( $source, $target )
  {
    if ( is_dir( $source ) )
    {
      @mkdir( $target );
      $d = dir( $source );
      while ( FALSE !== ( $entry = $d->read() ) )
      {
          if ( $entry == '.' || $entry == '..' )
          {
              continue;
          }
          $Entry = $source . '/' . $entry;
          if ( is_dir( $Entry ) )
          {
              full_copy( $Entry, $target . '/' . $entry );
              continue;
          }
          copy( $Entry, $target . '/' . $entry );
      }

      $d->close();
    }
    else
    {
        copy( $source, $target );
    }
  }



}