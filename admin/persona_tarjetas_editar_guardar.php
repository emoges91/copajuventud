<?php

include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/torneos/eventos.php';
include 'module/torneos/jornadas.php';

$oTorneo = new torneo();
$oEventos = new eventos();
$oJornadas = new jornadas();

function buscar_punto($cadena) {
    if (strrpos($cadena, "."))
        return true;
    else
        return false;
}

if (($_POST['goles'] >= 0) and ($_POST['jornada'] > 0)) {

    if (($_POST['tar_ama'] == true) || ($_POST['tar_roj'] == true) || ($_POST['goles'] >= 0)) {
        if ((buscar_punto($_POST['jornada']) == false) && (is_numeric($_POST['jornada']) == true) && (buscar_punto($_POST['goles']) == false) && (is_numeric($_POST['goles']))) {
            $sql = "SELECT * FROM t_est_jug_disc WHERE ID_JUGADOR=" . $_POST['id_jug'] . " AND ID_TORNEO=" . $_POST['torneo'] . " AND JORNADA=" . $_POST['jornada'] . "";
            $query = mysql_query($sql, $conn);
            $caant = mysql_num_rows($query);
            if ($caant == 0) {
                $cadena = "SELECT * FROM t_torneo WHERE ACTUAL=1";
                $consulta_torneo = mysql_query($cadena, $conn);
                $fila = mysql_fetch_assoc($consulta_torneo);

                $sql = "SELECT * FROM t_eventos WHERE ID_TORNEO=" . $fila['ID'] . " AND TIPO=1";
                $query = mysql_query($sql, $conn);
                $cant = mysql_num_rows($query);
                $row = mysql_fetch_assoc($query);

                $sql = "SELECT * FROM t_eventos WHERE ID_TORNEO=" . $fila['ID'] . "";
                $query = mysql_query($sql, $conn);
                while ($row = mysql_fetch_assoc($query)) {
                    $cadena_equi = "SELECT * FROM t_jornadas WHERE ESTADO=4 AND ID_EVE=" . $row['ID'] . " ORDER BY NUM_JOR ASC";
                    $consulta_total_jornadas = mysql_query($cadena_equi, $conn);
                    while ($total_jornadas = mysql_fetch_assoc($consulta_total_jornadas)) {
                        if (($total_jornadas['MARCADOR_VISITA'] != NULL) AND ($jornadas <= $total_jornadas['NUM_JOR'])) {
                            $jornadas = $total_jornadas['NUM_JOR'];
                        }
                    }
                }
                if ($_POST['jornada'] < $jornadas) {
                    $tar_ama = 0;
                    $tar_roj = 0;
                    if ($_POST['tar_ama'] == true) {
                        $tar_ama = 1;
                    }
                    if ($_POST['tar_roj'] == true) {
                        $tar_roj = 1;
                    }
                    $sql = "INSERT INTO t_est_jug_disc 
                        VALUES (null,'" . $_POST['torneo'] . "','" . $_POST['id_equi'] . "','" . $_POST['id_jug'] . "','" . $tar_ama . "','" . $tar_roj . "','" . $_POST['jornada'] . "','" . $_POST['goles'] . "')";
                    $query = mysql_query($sql, $conn) or die(mysql_error());

                    $sqlerickselect = "SELECT * FROM t_est_jug WHERE ID_PERSONA = " . $_POST['id_jug'] . " AND ID_TORNEO = " . $_POST['torneo'] . " AND ID_EQUI=" . $_POST['id_equi'] . "";
                    $queryerickselect = mysql_query($sqlerickselect, $conn) or die(mysql_errno());
                    $rowerickselect = mysql_fetch_assoc($queryerickselect);
                    $numrowserick = mysql_num_rows($queryerickselect);

                    if ($numrowserick > 0) {
                        $golesdeltorneo = $rowerickselect['GOLANO'];
                        $tempogoles = $golesdeltorneo + $_POST['goles'];

                        $sqlerickmodifi = "UPDATE t_est_jug SET GOLANO=" . $tempogoles . " WHERE ID_PERSONA = " . $_POST['id_jug'] . " AND ID_TORNEO = " . $_POST['torneo'] . " AND ID_EQUI=" . $_POST['id_equi'] . "";
                        $queryerercikmodifi = mysql_query($sqlerickmodifi, $conn) or die(mysql_error());
                    } else {
                        $sqlerickmodifi = "INSERT INTO t_est_jug VALUES (null,'" . $_POST['id_jug'] . "','" . $_POST['id_equi'] . "','" . $_POST['torneo'] . "','" . $_POST['goles'] . "',0)";
                        $queryerercikmodifi = mysql_query($sqlerickmodifi, $conn) or die(mysql_error());
                    }

                    echo "<script type=\"text/javascript\"> 
                        alert('Tarjeta(s) y/o goles registrada(s) correctamente '); 
					document.location.href='torneo_jugador_est.php?id=" . $_POST['id_jug'] . "&idequi=" . $_POST['id_equi'] . "';
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
			alert('Debe de elegir una opcion');
			history.go(-1);
	</script>";
    }
} else {
    echo "<script type=\"text/javascript\"> 
        alert('El numero de goles y/o jornadas debe ser igual o mayor de cero (0)');
		history.go(-1);
		</script>";
}
?>