<?php
include('conexiones/conec_cookies.php');



$sql = "UPDATE t_equipo SET	
		ACTIVO= 0
		WHERE ID = '".$_GET['id']."'";
$query = mysql_query($sql, $conn);


echo "<script type=\"text/javascript\">
	document.location.href='crear_torneo.php';
</script>";
?>