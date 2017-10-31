<?php

include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/torneos/eventos.php';
include 'module/equipos/jugadores.php';
include 'module/personas/personas.php';
include 'module/equipos/equipos.php';

$oPersona = new personas();
$oEquipo = new equipos();
$oJugadores = new jugadores();

$nPersonaID = (isset($_POST['ID'])) ? $_POST['ID'] : '0';
$nEquipo = (isset($_POST['EQUIPO'])) ? $_POST['EQUIPO'] : '';
$nAction = (isset($_POST['ACTION'])) ? $_POST['ACTION'] : '';
//
$nJugador = (isset($_POST['JUGADOR'])) ? $_POST['JUGADOR'] : '';
$nCHDT = (isset($_POST['DT'])) ? $_POST['DT'] : '';
$nAsistente = (isset($_POST['ASISTENTE'])) ? $_POST['ASISTENTE'] : '';
$nRepresentante = (isset($_POST['REPRESENTANTE'])) ? $_POST['REPRESENTANTE'] : '';
$nSuplente = (isset($_POST['SUPLENTE'])) ? $_POST['SUPLENTE'] : '';

$bControl = 0;
$bReg = 0;
$aErrors = array();

if (($nJugador != '') || ( $nCHDT != '') || ( $nAsistente != '') || ($nRepresentante != '') || ( $nSuplente != '')) {

    $aJugadores = $oPersona->getTotalJugadoresEquipo($nEquipo, $sTorVerID);
    $aDT = $oPersona->getTotalDTEquipo($nEquipo, $sTorVerID);
    $aSup = $oPersona->getTotalDTSupEquipo($nEquipo, $sTorVerID);
    $aRep = $oPersona->getTotalRepEquipo($nEquipo, $sTorVerID);
    $aRepSup = $oPersona->getTotalRepSupEquipo($nEquipo, $sTorVerID);

    $nJugadores = count($aJugadores);
    $nDT = count($aDT);
    $nSup = count($aSup);
    $nRep = count($aRep);
    $nRepSup = count($aRepSup);

    ///////// validar jugador registrado
    if ($nAction == 'add') {
        $nJugReg = $oJugadores->valRegTorneo($sTorVerID, $nPersonaID);
        $nJugRegEquipo = $oJugadores->valEnEquipo2($nEquipo, $sTorVerID, $nPersonaID);

        if ($nJugRegEquipo > 0) {
            $aErrors[] = 'Este jugador esta registrado en este Equipo.';
            $bReg = 1;
        }

        if ($nJugReg > 0 && $nJugRegEquipo == 0) {
            $aErrors[] = 'Este jugador ya ha sido registrado en algun Equipo.';
            $bReg = 1;
        }
    } else {
        $nJugRegEquipo = $oJugadores->valEnEquipo($nEquipo, $sTorVerID, $nPersonaID);
        if ($nJugRegEquipo != 1) {
            $aErrors[] = 'Este jugador no ha sido registrado en este Equipo.';
            $bReg = 1;
        }
    }

    if ($bReg == 0) {
        if (trim($nJugador) != '') {
            if ($nJugadores < 22) {
                $oPersona->setCargo($sTorVerID, $nPersonaID, 'Jugador');
                $bControl = 1;
            } else {
                $aErrors[] = 'La persona no se pudo guardar como Jugador por que la lista esta completa';
            }
        }

        if ($nCHDT != '') {
            if ($nDT < 1) {
                $oPersona->setCargo($sTorVerID, $nPersonaID, 'Director Tecnico');
                $bControl = 1;
            } else {
                $aErrors[] = 'La persona no se pudo guardar como Director Tecnico por que la lista esta completa';
            }
        }

        if ($nAsistente != '') {
            if ($nSup < 5) {
                $oPersona->setCargo($sTorVerID, $nPersonaID, 'Asistente');
                $bControl = 1;
            } else {
                $aErrors[] = 'La persona no se pudo guardar como Asistente del Cuerpo Tecnico por que la lista esta completa';
            }
        }

        if ($nRepresentante != '') {
            if ($nRep < 1) {
                $oPersona->setCargo($sTorVerID, $nPersonaID, 'Representante');
                $bControl = 1;
            } else {
                $aErrors[] = 'La persona no se pudo guardar como Reperesentante por que la lista esta completa';
            }
        }

        if ($nSuplente != '') {
            if ($nRepSup < 1) {
                $oPersona->setCargo($sTorVerID, $nPersonaID, 'Suplente');
                $bControl = 1;
            } else {
                $aErrors[] = 'La persona no se pudo guardar como Suplente de Representante por que la lista esta completa';
            }
        }

        if ($bControl == 1 && $bReg == 0) {
            if ($nAction == 'add') {
                $oPersona->setEquipo($sTorVerID, $nEquipo, $nPersonaID);
            } else {
                $oPersona->updateStatus($sTorVerID, $nEquipo, $nPersonaID);
            }
        }
    }

    if (count($aErrors) > 0) {
        $sMsg = 'Error: \n';
        for ($index = 0; $index < count($aErrors); $index++) {
            $sMsg = $aErrors[$index] . '\n';
        }
    }

    if ($bControl == 1 && $bReg == 0) {

        $sReturnLink = 'torneo_equipo_detalle.php';
        if ($nAction == 'add') {
            $sReturnLink = 'torneo_jugador_add.php';
        }
        echo "<script type=\"text/javascript\">
                alert('La persona fue registrada');
                document.location.href='" . $sReturnLink . "?id=" . $nEquipo . "';
            </script>";
    } else {

        $sReturnLink = 'torneo_jugador_enabled.php';
        if ($nAction == 'add') {
            $sReturnLink = 'torneo_jugador_add.php';
        }
        echo "
            <script type=\"text/javascript\">
                alert('" . $sMsg . "');
                document.location.href='" . $sReturnLink . "?id=" . $nEquipo . "&per_id=" . $nPersonaID . "';
            </script>";
    }
} else {
    echo "<script type=\"text/javascript\">
            alert('Debe de eligir un cargo por lo menos');
            history.go(-1);
        </script>";
}
?>