<?php
class Validation {

	static public function validate($cadena){
		$cadena = htmlspecialchars($cadena);
		$cadena = trim($cadena);
		$cadena = stripslashes($cadena);
		$cadena = nl2br($cadena);
		return $cadena;
	}

}