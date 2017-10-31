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
	//consultar  id grupo
	$row_grupo=mysql_fetch_assoc($query_grupo);
	
	//--------------------------consulta eventos fase de llave-------------------------
	$sql_llave = "SELECT * FROM t_eventos WHERE ID_TORNEO=".$_GET['ID']." and TIPO=2";
	$query_llave = mysql_query($sql_llave, $conn);
	$cant_llave = mysql_num_rows($query_llave);
	if($cant_llave>0){
		$row_llave=mysql_fetch_assoc($query_llave);	
		$cadena_jornadas_llave=" OR (t_jornadas.ID_EVE=".$row_llave['ID'].") ";
	}
	else{
		$cadena_jornadas_llave="";
	}
	
	//elimiar jornadas de grupo y llaves
	$cadena_jornadas="DELETE FROM t_jornadas
						WHERE (t_jornadas.ID_EVE=".$row_grupo['ID'].") ".$cadena_jornadas_llave;
	$consulta_jornadas = mysql_query($cadena_jornadas, $conn);
	
	//resetear las estadisticas de los equipos
	$cadena_est_equi="UPDATE t_est_equi SET 	
						PAR_JUG=0,
						PAR_GAN=0,
						PAR_EMP=0,
						PAR_PER=0,
						GOL_ANO=0,
						GOL_RES=0,
						PTS=0,
						PAR_JUG_ACU=0,
						PAR_GAN_ACU=0,
						PAR_EMP_ACU=0,
						PAR_PER_ACU=0,
						GOL_ANO_ACU=0,
						GOL_RES_ACU=0,
						PTS_ACU=0,
						POSICION=0
						WHERE t_est_equi.ID_TORNEO=".$_GET['ID'];
	$consulta_est_equi = mysql_query($cadena_est_equi, $conn);
	
	
	echo "<script type=\"text/javascript\">
			alert('Las jornadas de grupos se han borrado y las estadisticas de equipos se han reseteado.');
			document.location.href='../../index.php';
		</script>";
}
else{
	echo "<script type=\"text/javascript\">
				alert('No exite fase de grupos en este torneo.');
				history.go(-1);
			</script>";
}
?>