<?php
/**
 * Sistema Prosic
 * Funcion para recibir varios Post de un Grid Detalle
 * @package		Prosic
 * @author		Pamela Fernandez Landio
 * @copyright	Copyright 2011
 * @license		Pamela Fernandez Lansio
 * @since		Version 1.0
 * @filesource  Function PHP
 */
function recibir_varios_post($post,$nrocolumna,$nroregistro){	
	$total_registros 	= $nroregistro * $nrocolumna;
	$contador 		= 0;
	foreach ($post as $item) {
	    $datos[$contador] = $item;
	    $contador++;
	}		
	for ($i = 0; $i < $nroregistro; $i++) {	
	    $cadena = "";
	    $inicio = $i * $nrocolumna;
	    $fin = $nrocolumna * ($i + 1);
		    for ($j = $inicio; $j < $fin; $j++) {
		        $cadena.=$datos[$j] . '|';
		    }
	    $nueva_cadena = substr($cadena, 0, strlen($cadena) - 1);
	    $nuevo_array[$i] = $nueva_cadena;
	}
	return $nuevo_array;
}
?>
<?php
function BuscarIdModulo($array_modulo, $array_privilegio, $idmodulo) {
	for ($i = 0; $i <= count($array_modulo); $i++) {
		if ($array_modulo[$i] == $idmodulo) {
			$privilegio = $array_privilegio[$i];
		}
	}
	return $privilegio;
}
?>
<?php
function _sql($dato, $tipo) {
	if ($tipo == 't' && $dato!='') {
		return utf8_decode("'" . $dato . "'");
	}
	elseif($tipo == 't' && $dato=='') {
		return utf8_decode("'NULL'");
	}
	elseif($tipo == 'f' && $dato!='') {
		return utf8_decode("'" . $dato . "'");
	}
	elseif($tipo == 'f' && $dato=='') {
		return utf8_decode("'0000/00/00'");
	}
	elseif($tipo == 'n' && $dato!='') {
		return utf8_decode($dato);
	}
	elseif($tipo == 'n' && $dato=='') {
		return 0;
	}
}
?>
<?php
function array_to_json( $array ){

	if( !is_array( $array ) ){
		return false;
	}

	$associative = count( array_diff( array_keys($array), array_keys( array_keys( $array )) ));
	if( $associative ){

		$construct = array();
		foreach( $array as $key => $value ){

			// We first copy each key/value pair into a staging array,
			// formatting each key and value properly as we go.

			// Format the key:
			if( is_numeric($key) ){
				$key = "key_$key";
			}
			$key = "\"".addslashes($key)."\"";

			// Format the value:
			if( is_array( $value )){
				$value = array_to_json( $value );
			} else if( !is_numeric( $value ) || is_string( $value ) ){
				$value = "\"".addslashes($value)."\"";
			}

			// Add to staging array:
			$construct[] = "$key: $value";
		}

		// Then we collapse the staging array into the JSON form:
		$result = "{ " . implode( ", ", $construct ) . " }";

	} else { // If the array is a vector (not associative):

		$construct = array();
		foreach( $array as $value ){

			// Format the value:
			if( is_array( $value )){
				$value = array_to_json( $value );
			} else if( !is_numeric( $value ) || is_string( $value ) ){
				$value = "'".addslashes($value)."'";
			}

			// Add to staging array:
			$construct[] = $value;
		}

		// Then we collapse the staging array into the JSON form:
		$result = "[ " . implode( ", ", $construct ) . " ]";
	}

	return $result;
}


?>
<?php
function llenar_select_array($valores,$default=''){
	foreach($valores as $key =>$valor){
		if($key==$default)$selected = " selected= selected";
		else $selected="";

		echo "<option value=" .$key." ".$selected.">".$valor."</option>";
	}
}
?>
<?php
function _row_status($dato) {
	switch ($dato) {
		case "D": $return = "Desactivo";
		break;
		case "A": $return = "Activo";
		break;
		case "P": $return = "Pendiente";
		break;
	}
	return $return;
}
?>
<?php
function imagen_editar() {
	echo '<img src="../images/edit.gif" />';
}
?>
