<?php

include('conexiones/conec_cookies.php');
include 'module/torneos/eventos.php';
include_once('FPHP/funciones.php');

$sTorneoID = (isset($_POST['HidTorneo'])) ? $_POST['HidTorneo'] : '';
$nTotalJor = (isset($_POST['total_jornadas'])) ? $_POST['total_jornadas'] : '0';

$oEventos = new eventos();

$aEvento = $oEventos->getEvenByInstancia($sTorneoID, '1');

for ($i = 1; $i <= $nTotalJor; $i++) {
    $orden = $_POST['CbBPosicion' . $i];
    $cadenaid = trim($_POST['HidIdJornadas' . $i], ',');
    $elementos = explode(',', $cadenaid); //dividir el string de equipos del hidden del grupo
    $nro_elementos = count($elementos); // cantidad de equipos en el grupo

    $j = 0; // contador para los equipos
    while ($j < $nro_elementos) {
        $str = "
            UPDATE   t_jornadas 
            SET 
                NUM_JOR=" . $orden . "
            WHERE ID=" . $elementos[$j];
        $query = mysql_query($str);
        $j++;
    }
}

$str = "UPDATE t_jornadas 
    SET 
        ESTADO=0
    WHERE ID_EVE=" . $aEvento['ID'] . " AND NUM_JOR<>1";
$query = mysql_query($str, $conn) or die(mysql_error());

$str = "UPDATE t_jornadas 
    SET 
        ESTADO=2
    WHERE ID_EVE=" . $aEvento['ID'] . " AND NUM_JOR=1";
$query = mysql_query($str, $conn) or die(mysql_error());

echo "<script type=\"text/javascript\">
   		alert('El orden de jornadas ha sido guardado.');
		document.location.href='jornadas_grupos.php';
	</script>";
?>