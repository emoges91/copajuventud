<?php

include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/torneos/eventos.php';

$sTorneoID = (isset($_POST['TORNEO_ID'])) ? $_POST['TORNEO_ID'] : '0';
$sCanGru = (isset($_POST['CAN_GRU'])) ? $_POST['CAN_GRU'] : '0';

$oTorneo = new torneo();
$oEventos = new eventos();
$fila = $oTorneo->getTorneoByID($sTorneoID);
$aEvento = $oEventos->getEvenByInstancia($sTorneoID, '1');

$i = 1;
$flag = 0;
while ($i <= $sCanGru) {
    $nombre_grupo = "h_grupo" . $i;
    $flag = (isset($_POST[$nombre_grupo]) || $_POST[$nombre_grupo] != '') ? $flag : 1;
    $i++;
}

if ($sTorneoID != '0' and ($sCanGru > 0) and ($flag == 0)) {

    $i = 1;
    while ($i <= $sCanGru) {
        $nombre_grupo = "h_grupo" . $i;
        $sHGrupos = (isset($_POST[$nombre_grupo])) ? $_POST[$nombre_grupo] : '';
        $aEquipos = explode(',', $sHGrupos);
        $nElementos = count($aEquipos);

        $j = 0;
        for ($nE = 0; $nE < $nElementos; $nE++) {
            $nIDEquipo = substr($aEquipos[$nE], 2);
            $oEventos->updateEventoEquip($aEvento['ID'], $nIDEquipo, $i);
        }

        $i++;
    }

    echo "<script type=\"text/javascript\">
   			alert('Se conformaron los grupos correctamente.');
			document.location.href='torneo_tabla_grupos.php';
		</script>";
} else {
    echo "<script type=\"text/javascript\">
			alert('Los campos con asterisco (*) son requeridos');
			history.go(-1);
	</script>";
}
?>