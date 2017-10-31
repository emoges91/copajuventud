<?php

include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';

$nPerID = (isset($_GET['per_id'])) ? $_GET['per_id'] : 0;
$nEquiID = (isset($_GET['id'])) ? $_GET['id'] : 0;

$sql = "
    UPDATE t_tor_equi_per 
    SET TEP_STATUS=0 
    WHERE 
        TEP_PER_ID=" . $nPerID . " 
        AND TEP_TORNEO_ID=" . $sTorVerID . "";
$query = mysql_query($sql, $conn);
$sql = "DELETE FROM t_car_per WHERE ID_PERSONA=" . $nPerID." AND ID_TORNEO=".$sTorVerID."";
$query = mysql_query($sql, $conn);


echo "<script type=\"text/javascript\">
	alert('El jugador fue desactivado con exito');
	document.location.href='torneo_equipo_detalle.php?id=" . $nEquiID . "';
	</script>";
?>