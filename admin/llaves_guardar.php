<?php

include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/torneos/eventos.php';
include 'module/torneos/jornadas.php';
include 'module/equipos/equipos.php';

$oTorneo = new torneo();
$oEventos = new eventos();
$oJornadas = new jornadas();
$oEquipos = new equipos();

$sCantFases = (isset($_POST['hCantFases']) ? $_POST['hCantFases'] : '');
$sParIdaVuelta = (isset($_POST['ParIdaVuelta']) ? $_POST['ParIdaVuelta'] : '');
$sFinalIdaVuelta = (isset($_POST['FinalIdaVuelta']) ? $_POST['FinalIdaVuelta'] : '');


$fila = $oTorneo->getTorneoByID($sTorVerID);
$aEventoGrupos = $oEventos->getEvenByInstancia($sTorVerID, '1');
$aEventoLLaves = $oEventos->getEvenByInstancia($sTorVerID, '2');

$nUltimoNumGrupo = $oEventos->totalGrupos($aEventoGrupos['ID']);
$nLastJor = $oJornadas->getMaxJornadasByEvento($aEventoGrupos['ID']);

$nPartidosFisrtJor = (isset($_POST['hfase1']) ? $_POST['hfase1'] : '0');

//fin de comprobar fechas
//comprobar si se ingresaron lkos equipos y provar si son mas de dos
$bFlag = 0;
for ($nI = 1; $nI <= $nPartidosFisrtJor; $nI++) {
    $hidden_partido = "h_partido_" . $nI . "_1";
    $sLlavePartido = (isset($_POST[$hidden_partido]) ? $_POST[$hidden_partido] : '');
    list($nEquipoCasaID, $nEquipoVisitaID, $id_sobrante) = explode(',', $sLlavePartido);

    if (($sLlavePartido == '') || ($id_sobrante != '')) {
        $bFlag = 1;
    }
}
//fin de probar
//condicion para proceder a almacenar datos
if ($sCantFases != '' && ($sCantFases > 0) && ($bFlag == 0)) {

    $nLlaveCurrent = 1;
    $nJorCurrent = $nLastJor;
    $nGrupoCurrent = $nUltimoNumGrupo;
    $nCantPartidos = 0;
    $sFase = '';
    $nIncrementador = 1;

    if ($sParIdaVuelta == '1') {
        $nIncrementador = 2;
    }

    for ($nIFase = 1; $nIFase <= $sCantFases; $nIFase++) {

        $sFase = 'hfase' . $nIFase;
        $nCantPartidos = (isset($_POST[$sFase]) ? $_POST[$sFase] : '0');

        for ($nLlaveCurrent = 1; $nLlaveCurrent <= $nCantPartidos; $nLlaveCurrent++) {

            $nGrupoCurrent = $nGrupoCurrent + 1;
            $nEquipoCasaID = '0';
            $nEquipoVisitaID = '0';
            $nEstadoIDA = '0';

            if ($nIFase == 1) {
                $nombre_grupo = "h_partido_" . $nLlaveCurrent . "_1";
                list($nEquipoCasaID, $nEquipoVisitaID) = explode(',', $_POST[$nombre_grupo]);

                $nEquipoCasaID = substr($nEquipoCasaID, 2);
                $nEquipoVisitaID = substr($nEquipoVisitaID, 2);

                $oEventos->addEquipoToEvento($nEquipoCasaID, $aEventoLLaves['ID'], '0');
                $oEventos->addEquipoToEvento($nEquipoVisitaID, $aEventoLLaves['ID'], '0');

                $nEstadoIDA = '2';
            }

            $nIncrementador = $nJorCurrent + 1;

            $aSqlPartidoCasa = array(
                'EquiCasaID' => $nEquipoCasaID,
                'EquiVisitaID' => $nEquipoVisitaID,
                'Estado' => $nEstadoIDA,
                'NumJornada' => $nIncrementador,
                'EveID' => $aEventoLLaves['ID'],
                'Grupo' => $nGrupoCurrent
            );
            $oJornadas->saveJornada($aSqlPartidoCasa);

            if (($sParIdaVuelta == '1' && $nIFase != $sCantFases) || ($nIFase == $sCantFases && $sFinalIdaVuelta == 1)) {

                $nIncrementador = $nJorCurrent + 2;
                $aSqlPartidoVisita = array(
                    'EquiCasaID' => $nEquipoVisitaID,
                    'EquiVisitaID' => $nEquipoCasaID,
                    'Estado' => '0',
                    'NumJornada' => $nIncrementador,
                    'EveID' => $aEventoLLaves['ID'],
                    'Grupo' => $nGrupoCurrent
                );
                $oJornadas->saveJornada($aSqlPartidoVisita);
            }
        }
        $nJorCurrent = $nIncrementador;
    }

    echo "<script type=\"text/javascript\">
   		alert('Fase de llaves creada correctamente');
		document.location.href='llaves.php';
	</script>";
} else {
    echo "<script type=\"text/javascript\">
            alert('Erro: se ha agregado mas de un equipo en una llave o una llave a quedado vacia.');
            history.go(-1);
	</script>";
}
?>