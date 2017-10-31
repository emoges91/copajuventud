<?php
include('conexiones/conec_cookies.php');
if ($_POST['tar_roj']==true)
{
	$tar_ama=0;
	$tar_roj=1;
	$sql = "INSERT INTO t_est_jug_disc VALUES (null,'".$_POST['torneo']."','".$_POST['id_equi']."','".$_POST['id_jug']."','".$tar_ama."','".$tar_roj."','".$_POST['jornada']."',0)";
	$query = mysql_query($sql, $conn)or die(mysql_error());
	echo "<script type=\"text/javascript\"> alert('Tarjeta registrada correctamente'); 
		document.location.href='estad_juadores_direc.php?id=".$_POST['id_jug']."&idequi=".$_POST['id_equi']."';
		</script>";
}
else
{
	echo "<script type=\"text/javascript\">
			alert('Debe de asignar la tarjeta');
			history.go(-1);
	</script>";
}
?>