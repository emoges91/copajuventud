<?php
	include('../../conexiones/conec_cookies.php');

	if(
		(isset($_POST['equipo']) and ($_POST['equipo'] !=''))
	  )
	{
		$sql="INSERT INTO T_CON_DIS_AMI VALUES
				(null,
				 '".$_POST['equipo']."',
				 null,
				 null,
				 null,
				 null,
				 null,
				'".$_POST['id_torneo']."'
				)";
				
			$query = mysql_query($sql, $conn)or die(mysql_error());
			  
			  echo "<script type=\"text/javascript\">
		     alert('Guardado con exito');document.location.href='ctrl_disc.php?ID=".$_POST['id_torneo']."&NOMB=".$_POST['NOMB']."';
		     </script>";
	}
	else
	{
			echo "<script type=\"text/javascript\">alert('Por favor complete la informacion');history.go(-1);</script>";
	}
?>