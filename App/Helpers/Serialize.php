<?php
class Serialize {

	public function __construct() { }

	public static function unSerializeLang($string, $lang)
	{
		if( Serialize::isSerialized($string) )
		{
			$value = unserialize($string);

			if(isset($value[$lang]))
			{
					$value = $value[$lang];
			}
			else
			{
					$value = '';
			}
		return $value;

		}
		else{
			return $string ;
		}
	}

	public static function isSerialized( $data ) {
			// if it isn't a string, it isn't serialized
			if ( !is_string( $data ) )
					return false;
			$data = trim( $data );
			if ( 'N;' == $data )
				return true;
			if ( !preg_match( '/^([adObis]):/', $data, $badions ) )
				return false;
			switch ( $badions[1] ) {
				case 'a' :
				case 'O' :
				case 's' :
					if ( preg_match( "/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data ) )
					return true;
				break;

				case 'b' :
				case 'i' :
				case 'd' :
					if ( preg_match( "/^{$badions[1]}:[0-9.E-]+;\$/", $data ) )
						return true;
				break;
			}
			return false;
	}

	/**
	 * [array] : multiples rows
	 */
	public static function unSerializeArray( $array )
	{

		$data = array() ;

		if (!is_array($array) )
		{
			return $array ;
		}

		foreach ($array as $key => $row)
		{
			foreach ($row as $k => $value)
			{
				$row[$k] = Serialize::unSerializeLang($value, 'es') ;
			}
			array_push($data, $row);
		}

		return $data ;

	}

	/**
	 * [array] : only row
	 */
	public static function unSerializeRow( $array )
	{

		$data = array() ;

		if (!is_array($array) )
		{
			return $array ;
		}

			foreach ($array as $k => $value)
			{
				$array[$k] = Serialize::unSerializeLang($value, 'es') ;
			}
			array_push($data, $array);

		return $data ;

	}



}