<?php

include('conexiones/conec_cookies.php');


$nTorneo = (isset($_GET['id'])) ? $_GET['id'] : 0;
//-----borrar torneo
$sql = "SELECT * FROM t_torneo WHERE ID='" . $nTorneo . "' limit 0,1";
$query = mysql_query($sql, $conn);
$row = mysql_fetch_assoc($query);

$nMostrar = '0';

if ($row['MOSTRAR'] == '0') {
    $nMostrar = '1';
} else {
    $nMostrar = '0';
}

//---------borrar eventos---
$sql = "UPDATE t_torneo SET MOSTRAR=" . $nMostrar . "   WHERE ID='" . $nTorneo . "'";
$query = mysql_query($sql, $conn);

header("Location: torneo.php");
?>