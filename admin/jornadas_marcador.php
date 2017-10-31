<?php
include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/torneos/eventos.php';
include 'module/equipos/equipos.php';
include 'module/torneos/jornadas.php';


$oTorneo = new torneo();
$oEventos = new eventos();
$oEquipos = new equipos();
$oJornadas = new jornadas();

$fila = $oTorneo->getTorneoByID($sTorVerID);
$aEvento = $oEventos->getEvenByInstancia($sTorVerID, '1');

$aJornadas = $oJornadas->getJonadasSiguentes($aEvento['ID']);
$nCantJor = count($aJornadas);
$comparar_jornadas = '';
$nPartidosCont = 0;

include('sec/inc.head.php'); 
include('sec/inc.menu.php');
?>

<h1><?php echo $fila['NOMBRE'] . ' ' . $fila['YEAR']; ?></h1>
<h2><?php echo $aEvento['NOMBRE']; ?> - Ingresar marcadores</h2>
<?php
if ($nCantJor > 0) {


    for ($nI = 0; $nI < $nCantJor; $nI++) {
        $nPartidosCont++;
        //--------------------mostrar la jornada----------
        if ($aJornadas[$nI]['NUM_JOR'] <> $comparar_jornadas) {
            ?>
            <form action="jornadas_marcador_guardar.php" method="post">
                <input type="hidden" name="Hdn_jornadaActual" value="<?php echo $aJornadas[$nI]['NUM_JOR'] . '/' . $aEvento['ID']; ?>">
                <table  class="table_jornadas">
                    <tr>
                        <td colspan="10">
                            <?php echo 'Jornada ' . $aJornadas[$nI]['NUM_JOR']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Equipo Casa</td>
                        <td colspan="2">Marcador</td>
                        <td>Equipo visita</td>
                        <td>Fecha</td>
                        <td>Estado</td>
                        <td>Jornada</td>
                        <td>Grupo</td>
                    </tr>
                    <?php
                }

                $bloquear_marcador = 0;
                if ($aJornadas[$nI]['ID_EQUI_VIS'] == 0||$aJornadas[$nI]['ID_EQUI_CAS'] == 0) {
                    $bloquear_marcador = 1;
                }

                if ($bloquear_marcador == 1) {
                    $marcador_casa = '<input type="hidden" maxlength="2" size="8px" name="TXT_marcadorCasa' . $nPartidosCont . '" >';
                    $marcador_visita = '<input type="hidden" maxlength="2" size="8px" name="TXT_marcadorVisita' . $nPartidosCont . '">';
                    $check_input = '<input type="hidden" name="CHK_partidos' . $nPartidosCont . '" value="on">';
                } else {
                    $check_input = '<input type="checkbox" name="CHK_partidos' . $nPartidosCont . '"  checked="checked">';
                    $marcador_casa = '<input type="text" maxlength="2" size="8px" name="TXT_marcadorCasa' . $nPartidosCont . '">';
                    $marcador_visita = '<input type="text" maxlength="2" size="8px" name="TXT_marcadorVisita' . $nPartidosCont . '">';
                }
                $Hdn_id = 'hdn_idPartido' . $nPartidosCont;
                
                echo '<tr>
                          <input type="hidden" name="' . $Hdn_id . '" value="' . $aJornadas[$nI]['ID'] . '">
                        <td>  ' . $check_input . ' </td>
                        <td >' .  $aJornadas[$nI]['NOM_CASA'] . '</td>
                        <td >' . $marcador_casa . '</td>
                        <td >' . $marcador_visita . '</td>
                        <td >' .  $aJornadas[$nI]['NOM_VISITA'] . '</td>
                        <td >' . ($aJornadas[$nI]['FECHA']) . '</td>
                        <td >' . $aJornadas[$nI]['TJS_NOMBRE'] . '</td>
                        <td >' . $aJornadas[$nI]['NUM_JOR'] . '</td>
                        <td >' . $aJornadas[$nI]['GRUPO'] . '</td>
		</tr>';

                $comparar_jornadas = $aJornadas[$nI]['NUM_JOR'];
            }
            ?>
            <tr>
                <td colspan="8"></td>
                <td>
                    <input class="buton_css" type="submit"  value="Guardar">
                </td>
            </tr>
        </table>
        <input type="hidden" name="total_partidos" value="<?php echo $nPartidosCont; ?>">
    </form>
    <?php
} else {
    echo "<script type=\"text/javascript\">
			alert('Las jornadas no se encuentran creadas o todas los partidos se han jugado');";
    echo "document.location.href='jornadas_grupos.php';";
    echo "</script>";
}
?>
<?php
include('sec/inc.footer.php');
?>