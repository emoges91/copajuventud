<?php
include('conexiones/conec_cookies.php');	
$sql = "DELETE FROM t_equipo WHERE ID='".$_GET['ID']."'";
$query = mysql_query($sql, $conn);
   		echo "<script type=\"text/javascript\">
   					alert('Equipo eliminado');
					document.location.href='equipos.php';
			</script>";
?>