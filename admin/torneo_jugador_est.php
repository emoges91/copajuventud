<?php
include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/torneos/eventos.php';
include 'module/torneos/jornadas.php';
include 'module/equipos/equipos.php';
include 'module/personas/personas.php';

$oTorneo = new torneo();
$oEventos = new eventos();
$oJornadas = new jornadas();
$oEquipo = new equipos();
$oPersona = new personas();

$nPersonaID = (isset($_GET['per_id'])) ? $_GET['per_id'] : 0;
$nEquiID = (isset($_GET['idequi'])) ? $_GET['idequi'] : 0;

$aTorneo = $oTorneo->getTorneoByID($sTorVerID);
$aEquipo = $oEquipo->getByID($nEquiID);

$nJornadas = 0;


$sSql = "SELECT * FROM t_eventos WHERE ID_TORNEO=" . $aTorneo['ID'] . "";
$query = mysql_query($sSql, $conn);
while ($row = mysql_fetch_assoc($query)) {
    $cadena_equi = "SELECT * FROM t_jornadas WHERE ESTADO=4 AND ID_EVE=" . $row['ID'] . " ORDER BY NUM_JOR ASC";
    $consulta_total_jornadas = mysql_query($cadena_equi, $conn);
    while ($total_jornadas = mysql_fetch_assoc($consulta_total_jornadas)) {
        if (($total_jornadas['MARCADOR_VISITA'] != NULL) AND ($nJornadas <= $total_jornadas['NUM_JOR'])) {
            $nJornadas = $total_jornadas['NUM_JOR'];
        }
    }
}

$aPersona = $oPersona->getByID($nPersonaID);

include('sec/inc.head.php');
include('sec/inc.menu.php');
include('sec/inc.menu_equi.php');
?>
<h1><?php echo $aTorneo['NOMBRE'] . ' ' . $aTorneo['YEAR']; ?></h1>
<h2>Estadistica Jugador</h2>
<div width="100%" class="right">
    <input type="button" Value="Volver" onclick="document.location.href = '<?php echo 'torneo_equipo_detalle.php?id=' . $nEquiID; ?>';" class="buton_css">
</div>
<div class="clear"></div>
<hr/>


<div class="equipo_detail">
    <img class="left" src="<?php echo $aEquipo['url']; ?>" width="150px">

    <div  class="left">
        <h2><?php echo $aEquipo['EQ_NOMBRE']; ?></h2>
        <h5>
            Estado:
            <?php
            if ($aEquipo['ACTIVO'] == 1) {
                echo 'Activo';
            } else {
                echo 'No activo';
            }
            ?>
        </h5> 
        <p>Cancha oficial: <?php echo $aEquipo['CO_NOMBRE']; ?> </p>
        <p>Cancha alterna: <?php echo $aEquipo['CA_NOMBRE']; ?>  </p>
    </div>
    <div class="clear"></div>
</div>
<br/>


<?php
if ($nJornadas != 0) {
    ?>
    <div class="equipo_detail">
        <div  class="left">
            <h2>Jugador</h2>
            <h4><?php echo $aPersona['NOMBRE'] . ' ' . $aPersona['APELLIDO1'] . ' ' . $aPersona['APELLIDO2']; ?></h4>
            <h5><?php echo $aPersona['CED']; ?> </h5> 
        </div>
        <div class="clear"></div>
    </div>
    <h2> TARJETAS REGISTRADAS AL JUGADOR</h2>

    <br />
    <table class="table_jornadas">
        <tr>
            <td>Jornada</td>
            <td>Tarjeta amarilla</td>
            <td>Tarjeta roja</td>
            <TD>Goles</TD> 
        </tr>
        <?php
        $sql1 = "SELECT * FROM t_est_jug_disc WHERE ID_JUGADOR=" . $nPersonaID . " AND ID_TORNEO=" . $aTorneo['ID'] . " AND ID_EQUIPO=" . $nEquiID . " ORDER BY JORNADA ASC";
        $query1 = mysql_query($sql1, $conn);
        while ($tarjetas = mysql_fetch_assoc($query1)) {
            $ama = 'NO';
            $roj = 'NO';
            if ($tarjetas['TAR_AMA'] == 1) {
                $ama = 'SI';
            }
            if ($tarjetas['TAR_ROJ'] == 1) {
                $roj = 'SI';
            }
            echo'
		<tr>
                    <td>' . $tarjetas['JORNADA'] . '</td>
                    <td>' . $ama . '</td>
                    <td>' . $roj . '</td>
                    <td>' . $tarjetas['GOLEO'] . '</td> 
		</tr>';
        }
        ?>
    </table>

    <?php
}

include('sec/inc.footer.php');
?>