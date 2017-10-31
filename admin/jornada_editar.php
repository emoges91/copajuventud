<?php
include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/torneos/eventos.php';
include 'module/torneos/jornadas.php';

$sJorID = (isset($_GET['id'])) ? $_GET['id'] : '';

$oTorneo = new torneo();
$oEventos = new eventos();
$oJornadas = new jornadas();

$fila = $oTorneo->getTorneoByID($sTorVerID);
$aJornada = $oJornadas->getJorByID($sJorID);

$destino = "document.location.href='jornadas_grupos.php';";

$sql_evento = "SELECT * FROM t_eventos WHERE ID=" . $aJornada['ID_EVE'];
$consulta_evento = mysql_query($sql_evento, $conn);
$fila_evento = mysql_fetch_assoc($consulta_evento);

include('sec/inc.head.php'); 
include('sec/inc.menu.php');
?>

<h1><?php echo $fila['NOMBRE'] . ' ' . $fila['YEAR']; ?></h1>
<h2><?php echo $fila_evento['NOMBRE']; ?> - Editar Jornada</h2>
<hr/>
<?php
$bandera_libres = 0;
if ($aJornada['ID_EQUI_VIS'] == 0 || $aJornada['ID_EQUI_CAS'] == 0||$aJornada['ESTADO']==0||$aJornada['ESTADO']==1||$aJornada['ESTADO']==2) {
    $bandera_libres = 1;
}
?>

<form action="jornada_guardar_editar.php" method="post">
    <?php
    if ($bandera_libres == 0) {
        echo '<input type="hidden" name="hdn_marcadorCasa_viejo" value="' . $aJornada['MAR_CASA'] . '">';
        echo '<input type="hidden" name="hdn_marcadorVisita_viejo" value="' . $aJornada['MAR_VISITA'] . '">';
        echo '<input type="hidden" name="hdn_id" value="' . $aJornada['ID'] . '">';
        echo '<input type="hidden" name="hdn_estado" value="' . $aJornada['ESTADO'] . '">';
        echo '<input type="hidden" name="hdn_tipo" value="' . $fila_evento['TIPO'] . '">';
        echo '<input type="hidden" name="hdn_id_casa" value="' . $aJornada['ID_EQUI_CAS'] . '" >';
        echo '<input type="hidden" name="hdn_id_vis" value="' . $aJornada['ID_EQUI_VIS'] . '">';
    }
    ?>

    <table  class="table_jornadas">
        <tr>
            <td colspan="10">
                <?php echo 'Jornada ' . $aJornada['NUM_JOR']; ?>
            </td>
        </tr>
        <tr >
            <td>Equipo casa</td>
            <td colspan="2" class="align_center">Marcador</td>
            <td>Equipo visita</td>
            <td>Fecha</td>
            <td>Estado</td>
            <td>Jornada</td>
            <td>Grupo</td>
        </tr>
        <?php
        echo '
        <tr>
            <td  >' . $aJornada['NOM_CASA'] . '</td>
            <td >  ' . $aJornada['MAR_CASA'] . ' </td>
            <td >   ' . $aJornada['MAR_VISITA'] . ' </td>
            <td >' . $aJornada['NOM_VISITA'] . '</td>
            <td >' . $aJornada['FECHA'] . '</td>
            <td >' . $aJornada['TJS_NOMBRE'] . '</td>
            <td >' . $aJornada['NUM_JOR'] . '</td>
            <td >' . $aJornada['GRUPO'] . '</td>
        </tr>';

        if ($bandera_libres == 0) {
            echo '
                <tr>
                    <td ></td>
                    <td ><input type="text" maxlength="2" size="8px" name="TXT_marcadorCasa_nuevo" value=""></td>
                    <td ><input type="text" maxlength="2" size="8px" name="TXT_marcadorVisita_nuevo" value=""></td>
                    <td ></td>
                    <td colspan="7"></td>
                </tr> 
                ';
        }
        ?>
    </table>
    <br/>
    <div>
        <input type="submit" value="Guardar" class="buton_css">
         <input type="button" value="Cancelar" onClick="<?php echo $destino; ?>" class="buton_css"/>
    </div>
</form>


<?php
include('sec/inc.footer.php');
?>
