<?php

include('conexiones/conec_cookies.php');


$nPatrocinadorID = (isset($_GET['id'])) ? $_GET['id'] : 0;
//-----borrar torneo
$sql = "SELECT * FROM t_patrocinador WHERE ID='" . $nPatrocinadorID . "' limit 0,1";
$query = mysql_query($sql);
$row = mysql_fetch_assoc($query);

$nMostrar = '0';

if ($row['MOSTRAR'] == '0') {
    $nMostrar = '1';
} else {
    $nMostrar = '0';
}

//---------borrar eventos---
$sql = "UPDATE t_patrocinador SET MOSTRAR=" . $nMostrar . "   WHERE ID='" . $nPatrocinadorID . "'";
$query = mysql_query($sql);

header("Location: patrocinador.php");
?>