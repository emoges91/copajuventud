<?php
    include('../../conexiones/conec_cookies.php');
	$sql="DELETE FROM T_DOC_AMI WHERE ID='".$_GET['id']."'";
	$query=mysql_query($sql,$conn);
	header('location: registrar_documentos.php?ID='.$_GET['id_torneo'].'&NOMB='.$_GET['NOMB']);
?>