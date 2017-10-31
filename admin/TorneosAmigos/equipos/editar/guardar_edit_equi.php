<?php
include('../../conexiones/conec_cookies.php');
if (isset($_POST['nombre']) and ($_POST['nombre'] !='')){
	$sql = "UPDATE t_equipo SET 		
				NOMBRE='".$_POST['nombre']."'
		where ID=".$_POST['ID'];
	$query = mysql_query($sql, $conn)or die(mysql_error());

	echo "
	<script type=\"text/javascript\">
		alert('El equipo fue editado con exito');
		document.location.href='../../mostrar_torneo.php?ID=".$_POST['HidTorneo']."&NOMB=".$_POST['HidNomb']."';
	</script>";
}
else{
	echo "
	<script type=\"text/javascript\">
		alert('Los campos con asterisco (*) son requeridos');
		history.go(-1);
	</script>";
}
?>