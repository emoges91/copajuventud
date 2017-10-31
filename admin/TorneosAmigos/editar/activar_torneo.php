<?php
include('../conexiones/conec_cookies.php');

if($_GET['TIPO']==1){
	$sql="UPDATE t_torneo SET 
	ACTUAL=0
	WHERE ID=".$_GET['ID'];
	$consulta = mysql_query($sql, $conn);
}
else{
	$sql="UPDATE t_torneo SET 
	ACTUAL=2
	WHERE ID=".$_GET['ID'];
	$consulta = mysql_query($sql, $conn);
}
echo "<script type=\"text/javascript\">
		document.location.href='../index.php?ID=".$_GET['ID']."&NOMB=".$_GET['NOMB']."';
	</script>";
?>