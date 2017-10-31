<?php

    include('conexiones/conec_cookies.php');

if ((isset($_POST['ID'])and $_POST['ID'] != '') 
	and (isset($_POST['NOMBRE']) and $_POST['NOMBRE'] != '')
	and(isset($_POST['EDICION'])and $_POST['EDICION']!=''))
{
		 			$sql = "UPDATE t_torneo SET 
									NOMBRE = '".$_POST['NOMBRE']."',
									YEAR = '".$_POST['EDICION']."'
						
									WHERE ID = '".$_POST['ID']."'
									";
									$query = mysql_query($sql, $conn);
					
					
   		echo "<script type=\"text/javascript\">
   					alert('El torneo editada');
					document.location.href='torneo.php';
			</script>";
	
	}
else{
	echo "<script type=\"text/javascript\">
		alert('Los campos con asterisco (*) son requeridos');
		history.go(-1);
	</script>";
}
