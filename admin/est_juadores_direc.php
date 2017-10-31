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

$fila = $oTorneo->getTorneoByID($sTorVerID);
$aEvento = $oEventos->getEventosByID($sTorVerID, '1');

$sql = "SELECT * FROM t_equipo WHERE ID = '" . $nEquiID . "'";
$query = mysql_query($sql, $conn);
$fila_equi = mysql_fetch_assoc($query);

$sql = "SELECT * FROM t_eventos WHERE ID_TORNEO=" . $fila['ID'] . "";
$query = mysql_query($sql, $conn);
while ($row = mysql_fetch_assoc($query)) {
    $cadena_equi = "SELECT * FROM t_jornadas WHERE ESTADO=4 AND ID_EVE=" . $row['ID'] . " ORDER BY NUM_JOR ASC";
    $consulta_total_jornadas = mysql_query($cadena_equi, $conn);
    while ($total_jornadas = mysql_fetch_assoc($consulta_total_jornadas)) {
        if (($total_jornadas['MARCADOR_VISITA'] != NULL) AND ($jornadas <= $total_jornadas['NUM_JOR'])) {
            $jornadas = $total_jornadas['NUM_JOR'];
        }
    }
}

$sql_jugador = "SELECT * FROM t_personas WHERE ID=" . $nPersonaID . "";
$consulta_jugador = mysql_query($sql_jugador, $conn);
$fila_jugador = mysql_fetch_assoc($consulta_jugador);


include('sec/inc.head.php'); 
include('sec/inc.menu_equi.php');
?>

<style>
    .puntero{
        Cursor : pointer;

    }
</style>
<script>
    function mouse_arriba(elemento) {

        var trElemnto = document.getElementById(elemento);
        elemento.bgColor = "#FFee88";
    }
    function mouse_fuera(elemento) {

        var trElemnto = document.getElementById(elemento);
        elemento.bgColor = "";
    }
</script>

<h1><?php echo $fila['NOMBRE'] . ' ' . $fila['YEAR']; ?></h1>
<h2><?php echo $fila_equi['NOMBRE']; ?></h2>
<hr/>
<?php
if ($jornadas != 0) {
    $sSqlEst = "
        SELECT 
            * 
        FROM t_est_jug_disc 
        WHERE 
            ID_JUGADOR=" . $nPersonaID . " 
            AND ID_TORNEO=" . $fila['ID'] . " 
            AND ID_EQUIPO=" . $fila_jugador['ID_EQUI'] . " 
            AND JORNADA=" . $jornadas . "";
    $query1 = mysql_query($sSqlEst, $conn);
    $row1 = mysql_num_rows($query1);

    echo '<p>REGISTRO DE TARJETAS DIRECTOR TECNICO Y ASISTENTES</p>';

    if (($row1 == 0)) {
        echo'
            <h3>Jornada ' . $jornadas . '</h3> 
            <form action="est_jug_dir_guardar.php" method="post">
                <input type="hidden" name="torneo" value="' . $fila['ID'] . '">
                <input type="hidden" name="jornada" value="' . $jornadas . '">
                <input type="hidden" name="id_jug" value="' . $fila_jugador['ID'] . '">
                <input type="hidden" name="id_equi" value="' . $nEquiID . '">
                <table class="table_jornadas">
                    <tr >
                        <td>Cedula</td>
                        <td>Nombre</td>
                        <td>Apellido Pa.</td>
                        <td>Apellido Ma.</td>
                        <td>Tarjeta Roja</td>
                        <td></td> 
                    </tr>
                    <tr >
                        <td>' . $fila_jugador['CED'] . '</td>
                        <td>' . $fila_jugador['NOMBRE'] . '</td>
                        <td>' . $fila_jugador['APELLIDO1'] . '</td>
                        <td>' . $fila_jugador['APELLIDO2'] . '</td>
                        <td><input type="checkbox" name="tar_roj" checked/></td>
                        <td>
                            <input type="submit" value="Guardar"> 
                        </td>
                    </tr>
                </table>
            </form>
                ';
    } else {
        echo'<p>FECHA ACTUAL: ' . $jornadas . '</p>';
    }
    ?>
    <br />
    <table class="table_jornadas">
        <tr >
            <td>Jornada</td>
            <td>Excluido</td>
            <td></td>
        </tr>
        <?php
        $sSqlTarjetas = "
        SELECT 
            * 
        FROM t_est_jug_disc 
        WHERE 
            ID_JUGADOR=" . $nPersonaID . " 
            AND ID_TORNEO=" . $fila['ID'] . " 
            AND ID_EQUIPO=" . $fila_jugador['ID_EQUI'] . " 
        ORDER BY JORNADA ASC";
        $query1 = mysql_query($sSqlTarjetas, $conn);
        while ($tarjetas = mysql_fetch_assoc($query1)) {
            $roj = '';
            if ($tarjetas['TAR_ROJ'] == 1) {
                $roj = 'SI';
            }
            echo'
            <tr onclick="" >
            <td>' . $tarjetas['JORNADA'] . '</td>
            <td>' . $roj . '</td>
            <td>
                <a href="tarjetas_dir_editar.php?per_id=' . $nPersonaID . '&idequi=' . $nEquiID . '&jor=' . $tarjetas['JORNADA'] . '&id=' . $nEquiID . '">Ver</a> 
            </td>
            </tr>
                ';
        }
        ?>
    </table>

    <?php
}
?> 

<?php
include('sec/inc.footer.php');
?>
