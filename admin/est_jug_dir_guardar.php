<?php

include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/torneos/eventos.php';
include 'module/torneos/jornadas.php';

$oTorneo = new torneo();
$oEventos = new eventos();
$oJornadas = new jornadas();

$nNumJor = (isset($_POST['jornada'])) ? $_POST['jornada'] : 0;
$sTarjetaRoja = (isset($_POST['tar_roj'])) ? $_POST['tar_roj'] : '';
$nPersonaID = (isset($_POST['id_jug'])) ? $_POST['id_jug'] : 0;
$nTorneoID = (isset($_POST['torneo'])) ? $_POST['torneo'] : 0;
$nEquipoID = (isset($_POST['id_equi'])) ? $_POST['id_equi'] : 0;


$nJornada = 0;

function buscar_punto($cadena) {
    if (strrpos($cadena, "."))
        return true;
    else
        return false;
}

if ($sTarjetaRoja == true) {
    if ((buscar_punto($nNumJor) == false) && (is_numeric($nNumJor) == true)) {

        $sSqlEstJugDisc = "
            SELECT * 
            FROM t_est_jug_disc 
            WHERE 
                ID_JUGADOR=" . $nPersonaID . " 
                AND ID_TORNEO=" . $nTorneoID . " 
                AND JORNADA=" . $nNumJor . "";
        $query = mysql_query($sSqlEstJugDisc, $conn);
        $caant = mysql_num_rows($query);
        if ($caant == 0) {

            $fila = $oTorneo->getTorneoByID($sTorVerID);

            $sql = "SELECT * FROM t_eventos WHERE ID_TORNEO=" . $fila['ID'] . "";
            $query = mysql_query($sql, $conn);
            while ($row = mysql_fetch_assoc($query)) {
                $cadena_equi = "SELECT * FROM t_jornadas WHERE ESTADO=4 AND ID_EVE=" . $row['ID'] . " ORDER BY NUM_JOR ASC";
                $consulta_total_jornadas = mysql_query($cadena_equi, $conn);
                while ($total_jornadas = mysql_fetch_assoc($consulta_total_jornadas)) {
                    if (($total_jornadas['MARCADOR_VISITA'] != NULL) AND ($nJornada <= $total_jornadas['NUM_JOR'])) {
                        $nJornada = $total_jornadas['NUM_JOR'];
                    }
                }
            }
            if ($nNumJor <= $nJornada) {
                $tar_ama = 0;
                $tar_roj = 1;
                $sql = "
                    INSERT INTO 
                        t_est_jug_disc 
                    VALUES 
                    (null,'" . $nTorneoID . "','" . $nEquipoID . "','" . $nPersonaID . "','" . $tar_ama . "','" . $tar_roj . "','" . $nNumJor . "',0)";
                $query = mysql_query($sql, $conn);

                echo "<script type=\"text/javascript\"> alert('Tarjeta registrada correctamente'); 
						document.location.href='est_juadores_direc.php?per_id=" . $nPersonaID . "&idequi=" . $nEquipoID . "&id=" . $nEquipoID . "';
				</script>";
            } else {
                echo "<script type=\"text/javascript\">
				alert('La jornada no se ha realizado');
				history.go(-1);
				</script>";
            }
        } else {
            echo "<script type=\"text/javascript\">
			alert('Ya hay tarjetas registradas en esa jornada');
			history.go(-1);
			</script>";
        }
    } else {
        echo "<script type=\"text/javascript\">
		alert('Se deben digitar numeros enteros');
		history.go(-1);
		</script>";
    }
} else {
    echo "<script type=\"text/javascript\">
			alert('Debe de elejir la opcion');
			history.go(-1);
	</script>";
}
?>