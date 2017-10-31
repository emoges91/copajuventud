<?php

    include('conexiones/conec_cookies.php');

if ((isset($_POST['NOMBRE'])and $_POST['NOMBRE'] != '') and (isset($_POST['DIR']) and $_POST['DIR'] != ''))
{
	 
	 $sql = "UPDATE t_cancha SET
NOMBRE = '".$_POST['NOMBRE']."',
DIR = '".$_POST['DIR']."'
WHERE ID = '".$_POST['ID']."'";
    $query = mysql_query($sql, $conn);

   echo "<script type=\"text/javascript\">alert('Cancha Editada correctamente');document.location.href='registrar_canchas.php';</script>";
}
else
{
	echo "<script type=\"text/javascript\">alert('Los campos con asterisco (*) son requeridos');history.go(-1);</script>";
}


?>