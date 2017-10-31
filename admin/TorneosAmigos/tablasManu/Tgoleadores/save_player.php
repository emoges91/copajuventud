<?php
 include('../../conexiones/conec_cookies.php');
 
 if (
	(isset($_POST['nombre']) and ($_POST['nombre'] !='')) and
	 (isset($_POST['apellido1']) and ($_POST['apellido1'] !=''))and
	  (isset($_POST['apellido2']) and ($_POST['apellido2'] !=''))and
	  (isset($_POST['equipo']) and ($_POST['equipo'] !=''))
	)
	{
		$sql="INSERT INTO T_GOL_AMI VALUES
				(null,
				 '".$_POST['nombre']."',
				 '".$_POST['apellido1']."',
				 '".$_POST['apellido2']."',
				 '".$_POST['equipo']."',
				 null,
				 null,
				 null,
				 null,
				 '".$_POST['id_torneo']."' 
				)
			  ";
			  
		$query = mysql_query($sql, $conn)or die(mysql_error());
			  
			  echo "<script type=\"text/javascript\">
		     alert('Guardado con exito');document.location.href='tabla_goleadores.php?ID=".$_POST['id_torneo']."&NOMB=".$_POST['NOMB']."';
		     </script>";
	}
	else
	{
		echo "<script type=\"text/javascript\">alert('Por favor complete la informacion');history.go(-1);</script>";
	}
?>

