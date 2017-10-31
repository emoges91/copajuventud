<?php
include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/torneos/eventos.php';
include 'module/torneos/jornadas.php';

$oTorneo = new torneo();
$oEventos = new eventos();
$oJornadas = new jornadas();

$fila = $oTorneo->getTorneoByID($sTorVerID);
$aEventoLlave = $oEventos->getEvenByInstancia($sTorVerID, '2');
$aJornadas = $oJornadas->getJonadasPendientes($aEventoLlave['ID']);
$nCantJor = count($aJornadas);
$comparar_jornadas = '';

include('sec/inc.head.php'); 
include('sec/inc.menu.php');

?>
<h1><?php echo $fila['NOMBRE'] . ' ' . $fila['YEAR']; ?></h1>
<h2>Partidos Pendientes - Llaves</h2>
<?php
if ($nCantJor > 0) {
    $contador_partidos = 0;
    for ($nI = 0; $nI < $nCantJor; $nI++) {
        $contador_partidos++;
        //--------------------mostrar la jornada----------
        if ($aJornadas[$nI]['NUM_JOR'] <> $comparar_jornadas) {
            ?>
            <form action="llaves_pendientes_guardar.php" method="post">
                <input type="hidden" name="Hdn_jornadaActual" value="<?php echo $aJornadas[$nI]['NUM_JOR'] . '/' . $aEventoLlave['ID']; ?>">
                <table class="table_jornadas">
                    <tr>
                        <td colspan="10" >
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
                if ($aJornadas[$nI]['ID_EQUI_VIS'] == 0 || $aJornadas[$nI]['ID_EQUI_CAS'] == 0) {
                    $bloquear_marcador = 1;
                }

                if ($bloquear_marcador == 1) {
                    $marcador_casa = '<input type="hidden"   name="TXT_marcadorCasa' . $contador_partidos . '" >';
                    $marcador_visita = '<input type="hidden"   name="TXT_marcadorVisita' . $contador_partidos . '">';
                    $check_input = '<input type="hidden" name="CHK_partidos' . $contador_partidos . '" value="on">';
                } else {
                    $check_input = '<input type="checkbox" name="CHK_partidos' . $contador_partidos . '"  checked="checked">';
                    $marcador_casa = '<input type="text" maxlength="3" size="8px" name="TXT_marcadorCasa' . $contador_partidos . '">';
                    $marcador_visita = '<input type="text" maxlength="3" size="8px" name="TXT_marcadorVisita' . $contador_partidos . '">';
                }

                $Hdn_id = 'hdn_idPartido' . $contador_partidos;
                echo '
                    <tr>
                        <td >
                            ' . $check_input . '
                            <input type="hidden" name="' . $Hdn_id . '" value="' . $aJornadas[$nI]['ID'] . '">
                        </td>
                        <td >' . $aJornadas[$nI]['NOM_CASA'] . '</td>
                        <td >' . $marcador_casa . '</td>
                        <td >' . $marcador_visita . '</td>
                        <td >' . $aJornadas[$nI]['NOM_VISITA'] . '</td> 
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
                    <input type="submit"  value="Guardar">
                    <input type="hidden" name="total_partidos" value="<?php echo $contador_partidos; ?>">
                </td>
            </tr>
        </table>
    </form>
    <?php
} else {
    echo "<script type=\"text/javascript\">
			alert('No se existen partidos pendientes');
			document.location.href='llaves.php';
		</script>";
}
include('sec/inc.footer.php');
?>