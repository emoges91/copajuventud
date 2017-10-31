<?php

include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/torneos/eventos.php';
include 'module/torneos/jornadas.php';

$oTorneo = new torneo();
$oEventos = new eventos();
$oJornadas = new jornadas();

$nEquipoID = (isset($_POST['id_equi'])) ? $_POST['id_equi'] : 0;
$sTarjetaRoja = (isset($_POST['tar_roj'])) ? $_POST['tar_roj'] : '';
$sTarjetaAma = (isset($_POST['tar_ama'])) ? $_POST['tar_ama'] : '';
$nTorneoID = (isset($_POST['torneo'])) ? $_POST['torneo'] : 0;
$nPersonaID = (isset($_POST['id_jug'])) ? $_POST['id_jug'] : 0;
$nNumJor = (isset($_POST['jornada'])) ? $_POST['jornada'] : 0;
$nGoles = (isset($_POST['goles'])) ? $_POST['goles'] : '';
$nPersonaEstID = (isset($_POST['id_jug_est'])) ? $_POST['id_jug_est'] : 0;

$sql = "DELETE FROM t_est_jug_disc WHERE ID='" . $nPersonaEstID. "'";
$query = mysql_query($sql, $conn);

echo "<script type=\"text/javascript\">
		alert('Tarjeta eliminada con exito');
		document.location.href='est_juadores_direc.php?per_id=" . $nPersonaID . "&idequi=" . $nEquipoID . "&id=" . $nEquipoID . "';
	 	</script>";
?>