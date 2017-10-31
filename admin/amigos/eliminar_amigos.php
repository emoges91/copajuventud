<?php
include('../conexiones/conec_cookies.php');

//consultar el torneo recien creado
$sql_torneo_cons="DELETE FROM t_tor_amigo
				WHERE ID=".$_GET['id'];				
$query_torneo_cons=mysql_query($sql_torneo_cons, $conn);

$sql_est="DELETE FROM t_est_amigos WHERE ID_TORNEO=".$_GET['id'];
$query_est=mysql_query($sql_est, $conn);
		
//editar jornadas
$sql_jor="DELETE FROM t_jor_amigos WHERE ID_TORNEO=".$_GET['id'];
$query_jor=mysql_query($sql_jor, $conn);	
echo"
	<script type=\"text/javascript\">
			alert('Torneo amigo editado correctamente');
			document.location.href='torneos_amigos.php';
	</script>";	
?>