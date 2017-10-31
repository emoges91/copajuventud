<?php
    include('conexiones/conec_cookies.php');
	$sql="DELETE FROM t_personas WHERE ID='".$_GET['ID']."'";
	$query=mysql_query($sql,$conn);
	header('location: personas_sin_equipo.php');
?>