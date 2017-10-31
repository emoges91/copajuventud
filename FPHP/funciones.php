<?php
//cambiar la fecha a formato mysql
function cambiaf_a_mysql($fecha){
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
	$lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
	return $lafecha;
} 

//comprpbar la fecha
function comprobar_fecha($fecha){
	$resultado=0;
	$dia=0; $mes=0;$anio=0;
	list($dia, $mes,$anio ) = explode("/",$fecha);
	if(is_numeric($dia)){
		if(is_numeric($mes)){
			if(is_numeric($anio)){
				$resultado=checkdate($mes,$dia,$anio);
			}
			else{
				$resultado=0;}
		}
		else{
			$resultado=0;}
	}
	else{
		$resultado=0;
		}	
	return $resultado;
}
//--------------fin comprobar fecha

function cambiaf_a_normal($fecha){
	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
	$lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
	return $lafecha;
}

function buscar_punto($cadena){
	if (strrpos($cadena,".")){    
    	return true;     
	}
	else{    
    	return false;
	}
}

?>
