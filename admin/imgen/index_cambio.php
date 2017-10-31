<?php
	include('../conexiones/conec_cookies.php');
	echo "Cambiando y haciendo Thumbs <br/>";
	$cod = 0;
	$cod = $_GET['COD'];
	if ($cod==0)
	{
		$ccdo=@mkdir('original');
		$ccdt=@mkdir('thumbs');
		$ccdt3=@mkdir('thumbs300');
		if ($ccdo and $ccdt and $ccdt3)
		{
			echo 'Directorios creados Correctamente.<br/>';	
			$cod=1;
		}
		else
		{
			echo 'Directorios no creados Correctamente.<br/>';	
		}
	}
	if ($cod==1)
	{
		echo '<table border="1"><tr><td colspan="3">Lista de Galerias</td></tr>';
		$sqlalbun = "SELECT * FROM T_ALBUN";
		$queryalbun = mysql_query($sqlalbun, $conn) or die (mysql_error());
		while ($rowalbun=mysql_fetch_assoc($queryalbun))
		{
			echo '<tr><td>'.$rowalbun['NOMBRE'].'</td>';
			echo '<td>'.$rowalbun['URL'].'</td>';		
			echo '<td><a href="hacer_cambio.php?COD='.$cod.'&ID='.$rowalbun['ID'].'">Hacer Cambios</a></td></tr>';	
		}	
		echo '</table>';
	}
?>