<?php

include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/jornadas.php';
include 'module/torneos/torneo.php';
include 'module/torneos/eventos.php';

$oJornadas = new jornadas();

$nTotalPartidos = (isset($_POST['total_partidos'])) ? $_POST['total_partidos'] : '0';
$nNumJor = (isset($_POST['HidNumJor'])) ? $_POST['HidNumJor'] : '0';
$sJorTipo = (isset($_POST['HidTipo'])) ? $_POST['HidTipo'] : '';


//condicion que evalua si se procede a guardar
for ($i = 1; $i <= $nTotalPartidos; $i++) {
    $hora = $_POST['TXT_hora' . $i];
    $cancha = $_POST['TXT_cancha' . $i];
    $fecha = $_POST['piker_' . $i];
    $id_partido = $_POST['hdn_idPartido' . $i];

    $oJornadas->updateHorarios($id_partido, $fecha, $hora, $cancha);
}

echo "<script type=\"text/javascript\">
            alert('Los horarios han sido actualizados.');
            document.location.href='./jornadas_horarios.php?NUM_JOR=" . $nNumJor . "&TIPO=" . $sJorTipo . "';
    </script>";
?>