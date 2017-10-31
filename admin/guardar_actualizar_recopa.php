<?php
include('conexiones/conec_cookies.php');

function comprobar_maximo_equipos($cadena){
	$flag=0;
	for($i=0;$i<count($cadena);$i++){
		list($equipo_casa, $equipos_visita,$equipo_sobrante) = explode(",",$cadena[$i]);
		if( !(isset($equipo_casa))||!(isset($equipos_visita))||(isset($equipo_sobrante))){
			$flag=1;
		}
	}
	
	if($flag==0){
		return true;
	}
	else{
		return false;
	}
}

if(comprobar_maximo_equipos($_POST['h_grupo'])){
	$id_partido=$_POST['h_idGrupos'];
	$id_equipos=$_POST['h_grupo'];
	
	for($i=0;$i<count($id_partido);$i++){
	
		list($jornada_ida, $jornada_vuelta) = explode("/",$id_partido[$i]);
		list($equipo_casa, $equipos_visita) = explode(",",$id_equipos[$i]);
		
		$sql_jorn_ida="UPDATE t_jornadas SET 
						ID_EQUI_CAS=".$equipo_casa.",
						ID_EQUI_VIS=".$equipos_visita."
						WHERE ID=".$jornada_ida;
		$consulta_jorn_ida=mysql_query($sql_jorn_ida, $conn);		
			
		if(isset($jornada_vuelta)){
			$sql_jorn_vuelta="UPDATE t_jornadas SET 
						ID_EQUI_CAS=".$equipos_visita.",
						ID_EQUI_VIS=".$equipo_casa."
						WHERE ID=".$jornada_vuelta;
			$consulta_jorn_vuelta=mysql_query($sql_jorn_vuelta, $conn);
		}
			
	}
	
	echo "<script type=\"text/javascript\">
			alert('Jornadas registradas correctamente');
			document.location.href='recopa.php';
		</script>";
}
else{
	echo "<script type=\"text/javascript\">
			alert('Los marcadores de los partidos chekeados deben llevar numeros');
			history.go(-1);
		</script>";
}

?>