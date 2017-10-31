<?php

include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/torneos/eventos.php';
include 'module/torneos/jornadas.php';
include 'module/equipos/equipos.php';
include 'module/equipos/jugadores.php';
include 'module/equipos/jugadores_est.php';
include 'module/equipos/equipos_est.php';

$oTorneo = new torneo();
$oEventos = new eventos();
$oJornadas = new jornadas();
$oEquipos = new equipos();
$oJugadores = new jugadores();
$oJugadoresEst = new jugadores_est();
$oEquiposEst = new equipos_est();

$nJorNum = (isset($_POST['jor_num'])) ? $_POST['jor_num'] : '0';
$sJorID = (isset($_POST['jor_id'])) ? $_POST['jor_id'] : '0';
$sEventoTipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '1';
$sAction = (isset($_POST['action'])) ? $_POST['action'] : '';

$nEquiID1 = (isset($_POST['equi_id_1'])) ? $_POST['equi_id_1'] : '';
$nEquiID2 = (isset($_POST['equi_id_2'])) ? $_POST['equi_id_2'] : '';

$nNumJug1 = (isset($_POST['num_jug_1'])) ? $_POST['num_jug_1'] : 0;
$nNumJug2 = (isset($_POST['num_jug_2'])) ? $_POST['num_jug_2'] : 0;

$nEquiTarj1 = (isset($_POST['equi_tarj1'])) ? $_POST['equi_tarj1'] : 0;
$nEquiTarj2 = (isset($_POST['equi_tarj2'])) ? $_POST['equi_tarj2'] : 0;
$nEquiEstID1 = (isset($_POST['equi_est_id1'])) ? $_POST['equi_est_id1'] : '';
$nEquiEstID2 = (isset($_POST['equi_est_id2'])) ? $_POST['equi_est_id2'] : '';


$aTorneo = $oTorneo->getTorneoByID($sTorVerID);
$aEvento = $oEventos->getEvenByInstancia($sTorVerID, $sEventoTipo);
$aJornada = $oJornadas->getJornadasByID($nJorNum);


if ($sAction == 'save') {

    $nAma = '0';
    $nRoj = '0';
    $nTipo = '0';
    for ($nI = 0; $nI < $nNumJug1; $nI++) {

        $nEstID1 = (isset($_POST['est_1_jug_' . $nI])) ? $_POST['est_1_jug_' . $nI] : '';
        $nJugID1 = (isset($_POST['equi_1_jug_' . $nI])) ? $_POST['equi_1_jug_' . $nI] : '';
        $sJugAma1 = (isset($_POST['equi_1_ama_' . $nI])) ? $_POST['equi_1_ama_' . $nI] : 0;
        $sJugRoj1 = (isset($_POST['equi_1_roj_' . $nI])) ? $_POST['equi_1_roj_' . $nI] : 0;
        $nJugGol = (isset($_POST['equi_1_gol_' . $nI])) ? $_POST['equi_1_gol_' . $nI] : 0;

        if ($sJugAma1 == '1') {
            $nAma = '1';
        }

        if ($sJugRoj1 == '1') {
            $nRoj = '1';
        }

        if (trim($nEstID1) != '') {
            $nTipo = '1';
        }

        $oJugadoresEst->save($nTipo, $nEstID1, $nJorNum, $sTorVerID, $nJugID1, $nEquiID1, $nAma, $nRoj, $nJugGol);

        $nAma = '0';
        $nRoj = '0';
        $nTipo = '0';
    }

    ////////////////////////////////////////////////////////////////////////////

    $nAma = '0';
    $nRoj = '0';
    $nTipo = '0';
    for ($nI = 0; $nI < $nNumJug2; $nI++) {

        $nEstID2 = (isset($_POST['est_2_jug_' . $nI])) ? $_POST['est_2_jug_' . $nI] : '';
        $nJugID2 = (isset($_POST['equi_2_jug_' . $nI])) ? $_POST['equi_2_jug_' . $nI] : '';
        $nJugAma2 = (isset($_POST['equi_2_ama_' . $nI])) ? $_POST['equi_2_ama_' . $nI] : 0;
        $nJugRoj2 = (isset($_POST['equi_2_roj_' . $nI])) ? $_POST['equi_2_roj_' . $nI] : 0;
        $nJugGol2 = (isset($_POST['equi_2_gol_' . $nI])) ? $_POST['equi_2_gol_' . $nI] : 0;

        if ($nJugAma2 == '1') {
            $nAma = '1';
        }

        if ($nJugRoj2 == '1') {
            $nRoj = '1';
        }

        if (trim($nEstID2) != '') {
            $nTipo = '1';
        }

        $oJugadoresEst->save($nTipo, $nEstID2, $nJorNum, $sTorVerID, $nJugID2, $nEquiID2, $nAma, $nRoj, $nJugGol2);

        $nAma = '0';
        $nRoj = '0';
        $nTipo = '0';
    }

    $pnTipo = 0;
    if (trim($nEquiEstID1) != '') {
        $pnTipo = 1;
    }

    $oEquiposEst->save($pnTipo, $nEquiEstID1, $nJorNum, $sTorVerID, $nEquiID1, $nEquiTarj1);

    $pnTipo = 0;
    if (trim($nEquiEstID2) != '') {
        $pnTipo = 1;
    }
    $oEquiposEst->save($pnTipo, $nEquiEstID2, $nJorNum, $sTorVerID, $nEquiID2, $nEquiTarj2);

    echo "
        <script type=\"text/javascript\">
                alert('Los datos estadisticos has sido guardados.');
                document.location.href='jornadas_est.php?jor_id=" . $sJorID . "&tipo=".$sEventoTipo."';
        </script>";
} else {
    echo "
        <script type=\"text/javascript\">
            alert('Datos digitados incorrectamente.');
            history.go(-1);
	</script>";
}
?>
