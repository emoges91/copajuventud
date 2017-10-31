<?php
include('conexiones/conec_cookies.php');

$sql = "select * from t_equipo	
		WHERE ACTIVO = 1";
$query = mysql_query($sql, $conn);
$cant= mysql_num_rows($query);
if ($cant<25){

$sql = "UPDATE t_equipo SET	
		ACTIVO= 1
		WHERE ID = '".$_GET['id']."'";
$query = mysql_query($sql, $conn);
}



echo "<script type=\"text/javascript\">
	document.location.href='crear_torneo.php';
</script>";
?>