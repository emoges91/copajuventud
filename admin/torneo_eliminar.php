<?php
include('conexiones/conec_cookies.php');

$nTorneoID = (isset($_GET['id'])) ? $_GET['id'] : 0;

//-----borrar torneo
$sSql = "DELETE FROM t_torneo WHERE ID='" . $nTorneoID . "'";
$oQuery = mysql_query($sSql, $conn);

//---------escuger eventos
$sSql = "SELECT * FROM t_eventos WHERE ID_TORNEO='" . $nTorneoID . "'";
$oQuery = mysql_query($sSql, $conn);
while ($row = mysql_fetch_assoc($oQuery)) {

    //------borrar relaciones equipo-evento
    $sSql = "DELETE FROM t_even_equip WHERE ID_EVEN='" . $row['ID'] . "'";
    $consulta = mysql_query($sSql, $conn);
}

//---------borrar eventos---
$sSql = "DELETE FROM t_eventos WHERE ID_TORNEO='" . $nTorneoID . "'";
$oQuery = mysql_query($sSql, $conn);

$sSql = "DELETE FROM t_est_equi WHERE ID_TORNEO='" . $nTorneoID . "'";
$oQuery = mysql_query($sSql, $conn);

$sSql = "DELETE FROM t_est_jug_disc WHERE ID_TORNEO='" . $nTorneoID . "'";
$oQuery = mysql_query($sSql, $conn);

echo "<script type=\"text/javascript\">
	 alert('Torneo eliminado correctamente');
	 document.location.href='torneo.php';
	 </script>";
?>