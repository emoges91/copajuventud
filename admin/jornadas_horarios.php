<?php
include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/app/app_utils.php';
include 'module/torneos/torneo.php';
include 'module/torneos/eventos.php';
include 'module/torneos/jornadas.php';

$oTorneo = new torneo();
$oEventos = new eventos();
$oJornadas = new jornadas();

$sJorID = (isset($_GET['NUM_JOR'])) ? $_GET['NUM_JOR'] : '';
$sJorTipo = (isset($_GET['TIPO'])) ? $_GET['TIPO'] : '0';

$fila = $oTorneo->getTorneoByID($sTorVerID);
$aEvento = $oEventos->getEventosByID($sTorVerID, $sJorTipo);
$aJornadas = $oJornadas->getJornadasByNumJor2($sTorVerID, $sJorID);

$nCantJor = count($aJornadas);

if ($sJorTipo == 1) {
    $destino = "document.location.href='jornadas_grupos.php?ID=" . $_GET['ID'] . "&NOMB=" . $_GET['NOMB'] . "';";
} else {
    $destino = "document.location.href='llaves.php?ID=" . $_GET['ID'] . "&NOMB=" . $_GET['NOMB'] . "';";
}
$nContPartidos = 0;

include('sec/inc.head.php'); 
include('sec/inc.menu.php');
?>
<h1><?php echo $fila['NOMBRE'] . ' ' . $fila['YEAR']; ?></h1>
<h2><?php echo $aEvento['NOMBRE']; ?></h2>
<hr/>

<?php
if (($nCantJor > 0)) {
    ?>

    <form action="jornadas_horarios_guardar.php" method="post">
        <input name="HidNumJor" type="hidden" value="<?php echo $sJorID; ?>" />
        <input name="HidTorneo" type="hidden" value="<?php echo $_GET['ID']; ?>" />
        <input name="HidNomb" type="hidden" value="<?php echo $_GET['NOMB']; ?>" />
        <input name="HidTipo" type="hidden" value="<?php echo $sJorTipo; ?>" />
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr bgcolor="#cacaca">
                <td colspan="8">Asinar horarios de las jornada</td>
                <td align="right">
                    <input type="submit"  value="Guardar" class="buton_css">
                    <input type="button" value="Cancelar" onClick="<?php echo $destino; ?>" class="buton_css"/>
                </td>
            </tr>
        </table>
        <br/>
        <table class="table_jornadas">
            <tr>
                <td colspan="9" align="center"  >
                    Jornada <?php echo $sJorID; ?>
                </td>
            </tr>
            <tr>
                <th>Equipo Casa</th>
                <th>Equipo visita</th>
                <th>Estado</th>
                <th>Jornada</th>
                <th>Grupo</th>
                <th>Fecha</th>
                <th>Hora</th> 
                <th >Cancha</th>
            </tr>
            <?php
            for ($nI = 0; $nI < $nCantJor; $nI++) {
                $nContPartidos = $nI + 1;

                $habilitado = "";
                if ($aJornadas[$nI]['ID_EQUI_CAS'] == 0 || $aJornadas[$nI]['ID_EQUI_VIS'] == 0) {

                    $habilitado = 'disabled="disabled"';
                }
                ?>
                <tr> 
                    <td ><?php echo $aJornadas[$nI]['NOM_CASA']; ?></td>
                    <td ><?php echo $aJornadas[$nI]['NOM_VISITA']; ?></td>
                    <td ><?php echo $aJornadas[$nI]['TJS_NOMBRE']; ?></td>
                    <td ><?php echo $aJornadas[$nI]['NUM_JOR']; ?></td>
                    <td ><?php echo $aJornadas[$nI]['GRUPO']; ?></td>
                    <td >
                        <input name="piker_<?php echo $nContPartidos; ?>"   type="date" value="<?php echo $aJornadas[$nI]['FECHA']; ?>" <?php echo $habilitado; ?> />
                    </td>
                    <td >
                        <input type="time" max="23:59:59"  step="1" min="00:00:00" id="field<?php echo $nContPartidos; ?>"  name="TXT_hora<?php echo $nContPartidos; ?>" value="<?php echo $aJornadas[$nI]['HORA']; ?>" <?php echo $habilitado; ?> />
                    </td>
                    <td  >
                        <input  type="text" maxlength="100"  name="TXT_cancha<?php echo $nContPartidos; ?>"    value="<?php echo $aJornadas[$nI]['CANCHA']; ?>" <?php echo $habilitado; ?> />
                    </td>
                <input type="hidden" name="hdn_idPartido<?php echo $nContPartidos; ?>" value="<?php echo $aJornadas[$nI]['ID']; ?>" />
                </tr>
                <?php
            }
            ?>
            <input type="hidden" name="total_partidos" value="<?php echo $nContPartidos; ?>">
        </table>
    </form>


    <?php
} else {
    echo "
        <script type=\"text/javascript\">
            alert('Las jornadas no se han creado.');
        </script>";
}

include('sec/inc.footer.php');
?>
