<?php
    include('conexiones/conec_cookies.php');
	$sql="DELETE FROM t_cancha WHERE ID='".$_GET['id']."'";
	$query=mysql_query($sql,$conn);
	 echo "<script type=\"text/javascript\">alert('Cancha Eliminada correctamente');document.location.href='registrar_canchas.php';</script>";
	header('location: registrar_canchas.php');
?>
   