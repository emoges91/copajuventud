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
$aJornadas = $oJornadas->getJonadasPendientes($aEvento['ID']);
$nCantJor = count($aJornadas);
$comparar_jornadas = '';

include('sec/inc.head.php'); 
include('sec/inc.menu.php');
?>

<h1><?php echo $fila['NOMBRE'] . ' ' . $fila['YEAR']; ?></h1>
<h2><?php echo $aEvento['NOMBRE']; ?> - Partidos Pendientes</h2>
<?php
if ($nCantJor > 0) {
    $contador_partidos = 0;
    for ($nI = 0; $nI < $nCantJor; $nI++) {
        $contador_partidos++;
        //--------------------mostrar la jornada----------
        if ($aJornadas[$nI]['NUM_JOR'] <> $comparar_jornadas) {
            ?>
            <form action="jornadas_pendientes_guardar.php" method="post">
                <input type="hidden" name="Hdn_jornadaActual" value="<?php echo $aJornadas[$nI]['NUM_JOR'] . '/' . $aEvento['ID']; ?>">
                <table  class="table_jornadas">
                    <tr>
                        <td colspan="10" align="center">
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
                    $marcador_casa = '<input type="hidden" maxlength="3" size="8px" name="TXT_marcadorCasa' . $contador_partidos . '" >';
                    $marcador_visita = '<input type="hidden" maxlength="3" size="8px" name="TXT_marcadorVisita' . $contador_partidos . '">';
                    $check_input = '<input type="hidden" name="CHK_partidos' . $contador_partidos . '" value="on">';
                } else {
                    $check_input = '<input type="checkbox" name="CHK_partidos' . $contador_partidos . '"  checked="checked">';
                    $marcador_casa = '<input type="text" maxlength="3" size="8px" name="TXT_marcadorCasa' . $contador_partidos . '">';
                    $marcador_visita = '<input type="text" maxlength="3" size="8px" name="TXT_marcadorVisita' . $contador_partidos . '">';
                }

                $Hdn_id = 'hdn_idPartido' . $contador_partidos;
                echo '<tr>
                        <td align="center">
                            ' . $check_input . '
                            <input type="hidden" name="' . $Hdn_id . '" value="' . $aJornadas[$nI]['ID'] . '">
                        </td>
                        <td align="center">' . $aJornadas[$nI]['NOM_CASA'] . '</td>
                        <td align="center">' . $marcador_casa . '</td>
                        <td align="center">' . $marcador_visita . '</td>
                        <td align="center">' . $aJornadas[$nI]['NOM_VISITA'] . '</td>
                        <td align="center">' . ($aJornadas[$nI]['FECHA']) . '</td>
                        <td align="center">' . $aJornadas[$nI]['TJS_NOMBRE'] . '</td>
                        <td align="center">' . $aJornadas[$nI]['NUM_JOR'] . '</td>
                        <td align="center">' . $aJornadas[$nI]['GRUPO'] . '</td>
                    </tr>';

                $comparar_jornadas = $aJornadas[$nI]['NUM_JOR'];
            }
            ?>
            <tr>
                <td colspan="8"></td>
                <td>
                    <input class="buton_css"  type="submit"  value="Guardar">
                    <input type="hidden" name="total_partidos" value="<?php echo $contador_partidos; ?>">
                </td>
            </tr>
        </table>
    </form>
    <?php
} else {
    echo "<script type=\"text/javascript\">
    alert('No se existen partidos pendientes');
</script>";
}
include('sec/inc.footer.php');
?>