<?php
    include('../../conexiones/conec_cookies.php');
	$sql="DELETE FROM T_GOL_AMI WHERE ID='".$_GET['id']."'";
	$query=mysql_query($sql,$conn);
	header('location: tabla_goleadores.php?ID='.$_GET['id_torneo'].'&NOMB='.$_GET['NOMB'].'');
?>