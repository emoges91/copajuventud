<?php
include('../../conexiones/conec_cookies.php');

if ((isset($_POST['ID'])and $_POST['ID'] != '') and (isset($_POST['NOMBRE']) and $_POST['NOMBRE'] != '')){
	$sql = "UPDATE t_torneo SET 
				NOMBRE = '".$_POST['NOMBRE']."'
			WHERE ID = ".$_POST['ID'];
	$query = mysql_query($sql, $conn);
									
   	echo "<script type=\"text/javascript\">
   				alert('El torneo fue editado.');
				document.location.href='../../index.php';
	</script>";
	
}
else{
	echo "<script type=\"text/javascript\">
		alert('Se debe digitar un nombre para el torneo.');
		history.go(-1);
	</script>";
}
