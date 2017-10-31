<?php
include('../../conexiones/conec_cookies.php');

//-----------------------------------grupos----------------------------------------
$sql_grupo = "SELECT * FROM t_eventos WHERE ID_TORNEO=".$_GET['ID']." and TIPO=1";
$query_grupo = mysql_query($sql_grupo, $conn);
if($query_grupo==''){
	$cant_grupos=0;
}
else{
	$cant_grupos = mysql_num_rows($query_grupo);
}

if($cant_grupos>0){
	//--------------------------consulta eventos fase de llave-------------------------
	$sql_llave = "SELECT * FROM t_eventos WHERE ID_TORNEO=".$_GET['ID']." and TIPO=2";
	$query_llave = mysql_query($sql_llave, $conn);
	$row_llave=mysql_fetch_assoc($query_llave);		
	
	//eliminar jornadas de llaves
	$cadena_jornadas="DELETE FROM t_jornadas
					WHERE (t_jornadas.ID_EVE=".$row_llave['ID'].") ";
	$consulta_jornadas = mysql_query($cadena_jornadas, $conn);
	
	//eliminar la relacion con el equipo
	$cadena_even_equi="DELETE FROM t_even_equip
					WHERE ID_EVEN=".$row_llave['ID'];
	$consulta_even_equi = mysql_query($cadena_even_equi, $conn);
	
	//resetear las estadisticas de los equipos
	$cadena_est_equi="UPDATE t_est_equi SET 	
						PAR_JUG_ACU=PAR_JUG,
						PAR_GAN_ACU=PAR_GAN,
						PAR_EMP_ACU=PAR_EMP,
						PAR_PER_ACU=PAR_PER,
						GOL_ANO_ACU=GOL_ANO,
						GOL_RES_ACU=GOL_RES,
						PTS_ACU=PTS,
						POSICION=0
						WHERE t_est_equi.ID_TORNEO=".$_GET['ID'];
	$consulta_est_equi = mysql_query($cadena_est_equi, $conn);
	
	$sql_torneo="UPDATE t_torneo SET
					INSTANCIA=2
				WHERE ID=".$_GET['ID'];
	$consulta_torneo= mysql_query($sql_torneo, $conn);
	
	echo "<script type=\"text/javascript\">
			alert('Las jornadas de llaves y estadisticas de equipos se han borrado');
			document.location.href='../../index.php';
		</script>";
}
else{
	echo "<script type=\"text/javascript\">
				alert('A este torneo no se le debe borrar la fase de llaves.');
				history.go(-1);
			</script>";
}
?>