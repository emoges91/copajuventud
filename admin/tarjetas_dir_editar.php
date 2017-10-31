<?php

include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/torneos/eventos.php';
include 'module/torneos/jornadas.php';

$oTorneo = new torneo();
$oEventos = new eventos();
$oJornadas = new jornadas();

$nPersonaID = (isset($_GET['per_id'])) ? $_GET['per_id'] : 0;
$nEquiID = (isset($_GET['idequi'])) ? $_GET['idequi'] : 0;
$nNumJor = (isset($_GET['jor'])) ? $_GET['jor'] : 0;

$fila = $oTorneo->getTorneoByID($sTorVerID);

include('sec/inc.head.php');
include('sec/inc.menu_equi.php');


$sql_jugador = "SELECT * FROM t_personas WHERE t_personas.ID=" . $nPersonaID . "";
$consulta_jugador = mysql_query($sql_jugador, $conn);
$fila_jugador = mysql_fetch_assoc($consulta_jugador);

$sql1 = "SELECT * FROM t_est_jug_disc WHERE ID_JUGADOR=" . $nPersonaID . " AND ID_TORNEO=" . $fila['ID'] . " AND ID_EQUIPO=" . $nEquiID . " AND JORNADA=" . $nNumJor . "";
$query1 = mysql_query($sql1, $conn);
$row1 = mysql_fetch_assoc($query1);

if ($row1['TAR_ROJ'] == 1) {
    $tar_roj = 'checked';
}
echo'<p >Editar Tarjetas Jornada ' . $row1['JORNADA'] . '</p>
    <form action="tarjetas_dir_editar_guardar.php" method="post"> 
        <input type="hidden" name="torneo" value="' . $fila['ID'] . '">
        <input type="hidden" name="jornada" value="' . $nNumJor . '">
        <input type="hidden" name="id_jug" value="' . $fila_jugador['ID'] . '">
        <input type="hidden" name="id_equi" value="' . $nEquiID . '">
        <input type="hidden" name="id" value="' . $row1['ID'] . '">
        <table class="table_jornadas">
                <tr >
                        <td><b>Cedula</b></td>
                        <td><b>Nombre</b></td>
                        <td><b>Primer apellido</b></td>
                        <td><b>Segundo apellido</b></td>
                        <td><b>Tarjeta Roja</b></td>
                        <td></td> 
                </tr>
                <tr >
                        <td>' . $fila_jugador['CED'] . '</td>
                        <td>' . $fila_jugador['NOMBRE'] . '</td>
                        <td>' . $fila_jugador['APELLIDO1'] . '</td>
                        <td>' . $fila_jugador['APELLIDO2'] . '</td>
                        <td><input type="checkbox" name="tar_roj" ' . $tar_roj . '/></td>
                        <td><input type="submit" value="Modificar"> </td>
                </tr>
        </table>
    </form>';

include('sec/inc.footer.php');
?>