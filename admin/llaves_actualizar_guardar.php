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

$aGrupos = (isset($_POST['h_grupo']) ? $_POST['h_grupo'] : '');
$aPartidos = (isset($_POST['h_idGrupos']) ? $_POST['h_idGrupos'] : '');

function comprobar_maximo_equipos($cadena) {
    $flag = 0;
    for ($i = 0; $i < count($cadena); $i++) {
        list($nEquipoCasaID, $nEquipoVisitaID, $equipo_sobrante) = explode(",", $cadena[$i]);
        if (!(isset($nEquipoCasaID)) || !(isset($nEquipoVisitaID)) || (isset($equipo_sobrante))) {
            $flag = 1;
        }
    }

    if ($flag == 0) {
        return true;
    } else {
        return false;
    }
}

if (comprobar_maximo_equipos($aGrupos)) {
    $id_partido = $aPartidos;
    $id_equipos = $aGrupos;

    for ($i = 0; $i < count($id_partido); $i++) {

        list($jornada_ida, $jornada_vuelta) = explode("/", $id_partido[$i]);
        list($nEquipoCasaID, $nEquipoVisitaID) = explode(",", $id_equipos[$i]);

        $nEquipoCasaID = substr($nEquipoCasaID, 2);
        $nEquipoVisitaID = substr($nEquipoVisitaID, 2);

        $oJornadas->updateLlaves($jornada_ida, $nEquipoCasaID, $nEquipoVisitaID);

        if (isset($jornada_vuelta)) {
            $oJornadas->updateLlaves($jornada_vuelta, $nEquipoVisitaID, $nEquipoCasaID);
        }
    }

    echo "<script type=\"text/javascript\">
			alert('Jornadas actualizadas correctamente');
			document.location.href='llaves.php';
		</script>";
} else {
    echo "<script type=\"text/javascript\">
			alert('Error: mas de 2 equipos ingresados en una llave.');
			history.go(-1);
		</script>";
}
?>